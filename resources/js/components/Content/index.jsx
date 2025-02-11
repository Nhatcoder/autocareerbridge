import InfiniteScroll from "react-infinite-scroll-component";
import { useState, useRef, useEffect } from 'react';
import { useChat } from "@/contexts/chat-context";
import { formatDateChat } from "@/utils";
import Chat from "@/components/Chat";
import User from '@/components/User';
import classNames from "classnames/bind";
import styles from "./Content.module.scss";
import EmojiPicker from 'emoji-picker-react';
import NoChat from '@/components/NoChat';
import Loader from "@/components/Loader";
import Tippy from "@tippyjs/react";
import 'tippy.js/dist/tippy.css';
import axios from 'axios';

const cx = classNames.bind(styles);
const MAX_TEXTAREA_HEIGHT = 100;
const BASE_CHAT_HEIGHT = 180;
const ATTACHMENT_HEIGHT = 120;
function Content() {
    const { data, setMessageCt } = useChat();
    const chatMessages = data?.chats || [];
    const receiver = data?.receiver;
    const user = data?.user;

    const [emojiPickerOpen, setEmojiPickerOpen] = useState(false);
    const [messageValue, setMessageValue] = useState("");
    const [images, setImages] = useState([]);
    const [files, setFiles] = useState([]);
    const [chatMessage, setChatMessage] = useState(chatMessages.data || []);
    const [hasMoreChat, setHasMoreChat] = useState(chatMessages.current_page < chatMessages.last_page);
    const [currentPage, setCurrentPage] = useState(2);
    const [online, setOnline] = useState(false);

    const containerMessageRef = useRef(null);
    const refChat = useRef(null);
    const messageRef = useRef(null);

    // Lắng nghe sự kiện từ Pusher
    const channelName = `chat.${Math.min(user.id, receiver.id)}.${Math.max(user.id, receiver.id)}`;
    const channel = window.Echo.join(channelName);
    useEffect(() => {
        channel.here((users) => {
            const userOnline = users.find((u) => u.id === receiver.id);
            if (userOnline) {
                setOnline(true);
            }
        });

        channel.joining((user) => {
            console.log(user);
        })

        channel.leaving((user) => {
            console.log(user);
        })

        channel.listen("SendMessage", (e) => {
            const newMessage = e.message;
            console.log(newMessage);

            setMessageCt(() => {
                return newMessage;
            });
            setChatMessage((prevItems) => [newMessage, ...prevItems]);
        });
        return () => {
            channel.stopListening("SendMessage");
        };
    }, [chatMessage, receiver]);

    // Scoll chatMessage
    const getChatsScroll = async () => {
        if (!hasMoreChat) return;
        try {
            const response = await axios.get(`${chatMessages.path}?page=${currentPage}`);
            const newData = response.data;

            setChatMessage((prevItems) => [...prevItems, ...newData.data]);
            setCurrentPage(currentPage + 1);

            // Kiểm tra xem đã tải hết dữ liệu chưa
            if (currentPage >= chatMessages.last_page) {
                setHasMoreChat(false);
            }
        } catch (error) {
            console.error(error);
        }
    };

    // On/off emoji
    const toggleEmojiPicker = () => {
        setEmojiPickerOpen((prevState) => !prevState);
    };

    const handleEmojiClick = (emojiData) => {
        setMessageValue((prevValue) => prevValue + emojiData.emoji);
    };

    const handleGetMessage = (e) => {
        setMessageValue(e.target.value);
        const target = e.target;
        const inputValue = target.value.trim();

        if (inputValue === "") {
            target.style.height = "40px";
            let totalHeight = BASE_CHAT_HEIGHT;
            refChat.current.style.height = `calc(100vh - ${totalHeight}px)`;
            return;
        } else {
            const newHeight = Math.min(target.scrollHeight, MAX_TEXTAREA_HEIGHT);
            target.style.height = `${newHeight}px`;
        }

        updateChatHeight();
    };

    const handleGetFile = (fileList) => {
        const selectedImages = [];
        const selectedFiles = [];

        Array.from(fileList).forEach((file) => {
            if (file.type.startsWith("image/")) {
                selectedImages.push({ preview: URL.createObjectURL(file), file: file });
            } else {
                selectedFiles.push(file);
            }
        });

        setImages((prev) => [...prev, ...selectedImages]);
        setFiles((prev) => [...prev, ...selectedFiles]);
    };

    useEffect(() => {
        updateChatHeight();
    }, [images, files]);

    const updateChatHeight = () => {
        if (refChat.current) {
            let totalHeight = BASE_CHAT_HEIGHT;

            if (images.length > 0 || files.length > 0) {
                totalHeight += ATTACHMENT_HEIGHT;
            }

            if (messageRef.current) {
                totalHeight += Math.max(Math.min(messageRef.current.scrollHeight, MAX_TEXTAREA_HEIGHT) - 40, 0);
            }

            if (messageValue.trim() === "" && images.length === 0 && files.length === 0) {
                totalHeight = BASE_CHAT_HEIGHT;
            }
            refChat.current.style.height = `calc(100vh - ${totalHeight}px)`;
        }
    };

    const handleRemoveImage = (index) => {
        setImages((prevImages) => {
            const updatedImages = prevImages.filter((_, i) => i !== index);
            updateChatHeight();
            return updatedImages;
        });
    };

    const handleRemoveFile = (index) => {
        setFiles((prevFiles) => {
            const updatedFiles = prevFiles.filter((_, i) => i !== index);
            updateChatHeight();
            return updatedFiles;
        });
    };

    const handleSendMessage = () => {
        const messageText = messageValue?.trim();
        const formData = new FormData();

        if (messageText !== "" || images.length > 0 || files.length > 0) {
            const newMessage = {
                message: messageText || "",
                from_id: user?.id,
                to_id: receiver?.id,
            };

            formData.append("newMessage", JSON.stringify(newMessage));
            images.forEach((imgObj) => {
                formData.append("images[]", imgObj.file);
            });
            files.forEach((file) => {
                formData.append("files[]", file);
            });

            axios.post(route('chatStore'), formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
                .then(() => {
                    setMessageValue("");
                    setImages([]);
                    setFiles([]);
                })
                .catch((error) => {
                    console.error('Error sending message:', error);
                });
        }
    };

    return (
        <div className={cx("col-md-6 col-sm-12 position-relative px-0")}>
            <h4 className={cx("slogan")}>
                Cách mới để theo đuổi cơ hội của bạn.
                <span className={cx("text-primary")}>Tham gia nhiều hơn, thành công hơn</span>
            </h4>

            {receiver.id !== user.id && (
                <User online={online} />
            )}

            <div className={cx("chats", { active: chatMessages.last_page > 1 })} id="scrollableChats" ref={refChat}>
                <InfiniteScroll
                    dataLength={chatMessage.length}
                    next={getChatsScroll}
                    style={{ display: 'flex', flexDirection: 'column-reverse', overflow: 'hidden' }}
                    inverse={true}
                    hasMore={hasMoreChat}
                    loader={<Loader />}
                    scrollableTarget="scrollableChats"
                >
                    {chatMessage.length > 0 ? (
                        chatMessage.map((message, index) => {
                            const previousMessage = chatMessage[index - 1] || null;
                            const nextMessage = chatMessage[index + 1] || null;

                            const currentTime = new Date(message.sent_time);
                            const previousTime = previousMessage ? new Date(previousMessage.sent_time) : null;
                            const nextTime = nextMessage ? new Date(nextMessage.sent_time) : null;

                            // Kiểm tra nếu cần hiển thị timestamp (cách nhau > 5 phút)
                            const showTime = index === 0 || (previousTime && (currentTime - previousTime) > 5 * 60 * 1000);

                            // Kiểm tra nếu tin nhắn tiếp theo hoặc trước đó là của người khác hoặc cách nhau > 5 phút
                            const isDifferentSenderPrev = !previousMessage || previousMessage.user_id !== message.user_id;
                            const isTimeGapPrev = previousMessage && (currentTime - previousTime) > 5 * 60 * 1000;

                            const isDifferentSenderNext = !nextMessage || nextMessage.user_id !== message.user_id;
                            const isTimeGapNext = nextMessage && (nextTime - currentTime) > 5 * 60 * 1000;

                            return (
                                <div
                                    key={index}
                                    style={{
                                        marginTop: (isDifferentSenderPrev || isTimeGapPrev) ? "16px" : "2px",
                                        marginBottom: (isDifferentSenderNext || isTimeGapNext) ? "16px" : "2px",
                                    }}
                                >
                                    {showTime && (
                                        <div className={cx("timestamp")}>
                                            {formatDateChat(message.sent_time)}
                                        </div>
                                    )}
                                    <Chat
                                        message={message}
                                        user={user}
                                        receiver={receiver}
                                        nextMessage={nextMessage}
                                    />
                                </div>
                            );
                        })
                    ) : (
                        !receiver.id !== user.id && <NoChat />
                    )}
                </InfiniteScroll>
            </div >

            {
                emojiPickerOpen && (
                    <div className={cx("emoji-picker-container")} onMouseLeave={toggleEmojiPicker}>
                        <EmojiPicker
                            onEmojiClick={handleEmojiClick}
                            disableSkinTonePicker={false}
                            disableSearchBar={false}
                            locale="vi"
                        />
                    </div>
                )
            }

            {
                receiver && receiver.id !== user.id && (
                    <div className={cx("user_send__message")} ref={containerMessageRef}>
                        {(images.length > 0 || files.length > 0) && <div className={cx("attachments_message")}>
                            {images.length > 0 && images.map((image, index) => (<div className={cx("item_attachment")} key={index}>
                                <img className={cx("img_attachment")}
                                    src={image.preview}
                                    alt={`Preview ${index}`}
                                />
                                <button className={cx("remove_img")}
                                    onClick={() => handleRemoveImage(index)}
                                >
                                    <i className="fa-solid fa-xmark"></i>
                                </button>
                            </div>))}

                            {files.length > 0 && files.map((file, index) => (<div key={index} className={cx("item_attachment")}>
                                <div className={cx("file_attachment")}>
                                    <i className={cx("file_icon", "fa-solid fa-file-lines")}></i>
                                    <div className={cx("file_name")}>{file.name}</div>
                                </div>
                                <button className={cx("remove_img")}
                                    onClick={() => handleRemoveFile(index)}
                                >
                                    <i className="fa-solid fa-xmark"></i>
                                </button>
                            </div>))}
                        </div>}
                        <div className="d-flex align-items-end justify-content-between align-items-center px-4">
                            <Tippy
                                interactive={true}
                                delay={[0, 200]}
                                content={"Chọn nhãn dán"}
                                placement={"top"}
                            >
                                <div className={cx("more_icon")} onClick={toggleEmojiPicker}>
                                    <i className="fa-solid fa-face-smile"></i>
                                </div>
                            </Tippy>

                            <Tippy
                                interactive={true}
                                delay={[0, 200]}
                                content={"Đính kèm file"}
                                placement={"top"}
                            >
                                <label htmlFor="file_chat" className={cx("more_icon", "px-3")}>
                                    <i className="fa-solid fa-file-circle-plus"></i>
                                </label>
                            </Tippy>
                            <input id="file_chat" type="file" className="d-none" multiple onChange={(e) => handleGetFile(e.target.files)} />

                            <div className={cx("user_send")}>
                                <textarea
                                    ref={messageRef}
                                    cols="1"
                                    rows="1"
                                    className={cx("chat__input")}
                                    value={messageValue}
                                    onChange={handleGetMessage}
                                    onKeyDown={(e) => {
                                        if (e.key === 'Enter' && !e.shiftKey) {
                                            e.preventDefault();
                                            handleSendMessage();
                                        }
                                    }}
                                    placeholder="Aa"
                                />
                            </div>

                            <div className={cx("btn_send_message")} onClick={handleSendMessage}>
                                <i className="fa-solid fa-paper-plane"></i>
                            </div>
                        </div>
                    </div>
                )
            }
        </div >
    );
}

export default Content;
