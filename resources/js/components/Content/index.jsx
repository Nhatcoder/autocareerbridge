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

function Content() {
    const { data } = useChat();
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

    const containerMessageRef = useRef(null);
    const refChat = useRef(null);
    const messageRef = useRef(null);

    // Lắng nghe sự kiện từ Pusher
    useEffect(() => {
        const channel = window.Echo.channel('chat');
        channel.listen("SendMessage", (e) => {
            const newMessage = e.message;
            setChatMessage((prevItems) => [newMessage, ...prevItems]);
        });
        return () => {
            channel.stopListening("SendMessage");
        };
    }, [chatMessage]);

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

    // Get message
    const handleGetMessage = (e, baseHeight = 178) => {
        setMessageValue(e?.target?.value);

        const target = e?.target || messageRef.current;
        const inputValue = target.value.trim();

        if (inputValue === "") {
            target.style.height = "40px";
        } else {
            target.style.height = "auto";
            const newHeight = target.scrollHeight;

            const maxHeight = 100;
            target.style.height = `${Math.min(newHeight, maxHeight)}px`;
        }

        if (refChat.current) {
            const minTextareaHeight = 40;
            let extraHeight = 0;

            if (inputValue !== "") {
                extraHeight = Math.min(target.scrollHeight - minTextareaHeight, 100 - minTextareaHeight);
            }

            refChat.current.style.height = `calc(100vh - ${baseHeight + extraHeight}px)`;

            // Cuộn xuống cuối nếu có nội dung
            if (inputValue !== "") {
                refChat.current.scrollTop = refChat.current.scrollHeight;
            } else {
                refChat.current.scrollTop = 0;
            }
        }
    };

    // Get file and image
    const handleGetFile = (fileList) => {
        const selectedImages = [];
        const selectedFiles = [];

        Array.from(fileList).forEach((file) => {
            if (file.type.startsWith("image/")) {
                selectedImages.push({
                    preview: URL.createObjectURL(file),
                    file: file,
                });
            } else {
                selectedFiles.push(file);
            }
        });

        setImages((prevImages) => [...prevImages, ...selectedImages]);
        setFiles((prevFiles) => [...prevFiles, ...selectedFiles]);
        handleGetMessage(messageRef, 320);
    };

    const handleRemoveImage = (index) => {
        setImages((prevImages) => prevImages.filter((_, i) => i !== index));
    };

    const handleRemoveFile = (index) => {
        setFiles((prevFiles) => prevFiles.filter((_, i) => i !== index));
    };

    const handleSendMessage = () => {
        const messageText = messageValue.trim();
        const formData = new FormData();

        if (messageText !== "" || images.length > 0 || files.length > 0) {
            const newMessage = {
                message: messageText,
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

            {receiver && (
                <User />
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

                            const isAlone = index === chatMessage.length - 1;
                            const currentTime = new Date(message.sent_time);
                            const previousTime = previousMessage ? new Date(previousMessage.sent_time) : null;

                            const showTimestamp = !previousMessage ||
                                (currentTime - previousTime) / (1000 * 60) > 10;

                            return (
                                <div key={index}>
                                    {showTimestamp && (
                                        <div className={cx("timestamp")}>
                                            {formatDateChat(message.sent_time)}
                                        </div>
                                    )}
                                    <Chat
                                        message={message}
                                        user={user}
                                        isAlone={isAlone}
                                        previousMessage={previousMessage}
                                        nextMessage={nextMessage}
                                    />
                                </div>
                            );
                        })
                    ) : (
                        !receiver && <NoChat />
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
                receiver && (
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
