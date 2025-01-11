import { useState, useRef } from 'react';
import classNames from "classnames/bind";
import styles from "./ChatLayout.module.scss";
import EmojiPicker from 'emoji-picker-react';

import Sidebar from "@/layouts/partials/Sidebar";
import JobList from "@/layouts/partials/JobList";
import Chat from "@/components/Chat";

const cx = classNames.bind(styles);

function ChatLayout() {
    const [emojiPickerOpen, setEmojiPickerOpen] = useState(false);
    const refChat = useRef(null);

    const handleEmojiClick = (emojiData) => {
        const input = document.querySelector(`.${cx("chat__input")}`);
        input.value += emojiData.emoji;
    };

    const toggleEmojiPicker = () => {
        setEmojiPickerOpen(prevState => !prevState);
    };
    const handleSendMessage = (e) => {
        const target = e.target;
        const inputValue = target.value.trim();

        if (inputValue === "") {
            target.style.height = "40px";
        } else {
            target.style.height = "auto";
            const newHeight = target.scrollHeight;

            // Giới hạn chiều cao của textarea không vượt quá 68px
            const maxHeight = 100;
            target.style.height = `${Math.min(newHeight, maxHeight)}px`;
        }

        // Cập nhật chiều cao của `chats` dựa trên chiều cao của textarea
        if (refChat.current) {
            const baseHeight = 170;
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

    return (
        <div className={cx("container-fluid")}>
            <div className={cx("row")}>
                <Sidebar />
                <div className={cx("col-md-6 col-sm-12 position-relative px-0")}>
                    <h4 className={cx("slogan")}>Cách mới để theo đuổi cơ hội của bạn. <span className={cx("text-primary")}>Tham gia nhiều hơn, thành công hơn</span></h4>

                    <div className={cx("user", "d-flex", "align-items-center")}>
                        <img className={cx("user__avatar")} src="https://i.pinimg.com/736x/96/6a/8b/966a8b525b6ed406fde4520424f058be.jpg" alt="User" />
                        <div className="user_info">
                            <h6 className={cx("mb-0")}>Tuyển dụng</h6>
                            <small>Công ty TNHH...</small>
                        </div>
                    </div>

                    <div className={cx("chats")} ref={refChat}>
                        <Chat> </Chat>
                    </div>

                    {/* <div className={cx("no_chat")}>
                        <div className={cx("no_chat__content", "text-center")}>
                            <img className={cx("no_chat__img")} src="clients/images/no-chat.png" alt="No Chat" />
                            <p className={cx("text-muted")}>Bạn không có cuộc trò chuyện nào...</p>
                        </div>
                    </div> */}

                    {/* Trình chọn emoji */}
                    {emojiPickerOpen && (
                        <div className={cx("emoji-picker-container")} onMouseLeave={toggleEmojiPicker}>
                            <EmojiPicker
                                onEmojiClick={handleEmojiClick}
                                disableSkinTonePicker={false}
                                disableSearchBar={false}
                                locale="vi"
                            />
                        </div>
                    )}

                    <div className={cx("user_send__message", "d-flex align-items-end justify-content-between px-4")}>
                        {/* Biểu tượng cảm xúc */}
                        <div className={cx("more_icon")} onClick={toggleEmojiPicker}>
                            <i className="fa-solid fa-face-smile"></i>
                        </div>

                        <div className={cx("user_send")}>
                            <textarea
                                cols="1"
                                rows="1"
                                className={cx("chat__input")}
                                onInput={(e) => {
                                    handleSendMessage(e);
                                }}
                                type="text"
                                placeholder="Aa"
                            />

                        </div>

                        <div className={cx("btn_send_message")}>
                            <i className="fa-solid fa-paper-plane"></i>
                        </div>
                    </div>
                </div>
                <JobList />
            </div>
        </div >

    );
}

export default ChatLayout;
