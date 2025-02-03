import { useState } from "react";
import { Link } from "@inertiajs/react";

import { formatDate } from "@/utils";
import { useChat } from "@/contexts/chat-context";
import classNames from "classnames/bind";
import styles from "./Sidebar.module.scss";

const cx = classNames.bind(styles);

function Sidebar() {

    const { data } = useChat();
    const receiver = data?.receiver || [];
    const user = data?.user;
    const userChats = data?.userChats || [];

    return (
        <div className={cx("col-md-3", "sidebar", "border-right", "p-3")}>
            <div className={cx("top_sidebar d-flex justify-content-between align-items-center")}>
                <a href={route('home')} className={cx("logo")}>
                    <img src={`${window.location.origin}/clients/images/header/logo2.png`} alt="Logo"
                        title="Autocareerbridge" />
                </a>

                <div className={cx("action", "d-flex")}>
                    <a href={route('home')} className={cx("action__button--home")}>Về trang chủ</a>
                </div>
            </div>

            <div className={cx("box-search")}>
                <div className={cx("icon")}> <i className="fa-solid fa-magnifying-glass" /></div>
                <input type="text" className={cx("search__company", "form-control mb-3")} placeholder="Tên công ty, tên nhà tuyển dụng..." />
            </div>

            <div className={cx("jobs-list")}>
                {userChats && userChats.map((userChat, index) => {
                    const avatar = userChat.from_id == user.id ? `${window.location.origin}/${userChat.receiver_avatar || ""}` : `${window.location.origin}/${userChat.sender_avatar || ""}`;
                    const name = userChat.from_id == user.id ? userChat.receiver_name : userChat.sender_name;
                    const message = userChat.message;
                    const sentTime = formatDate(userChat.sent_time);
                    const you = userChat.from_id == user.id ? "Bạn: " : "";
                    const idChat = userChat.from_id != user.id ? userChat.from_id : userChat.to_id;
                    return (
                        <Link href={route('conversations', idChat)} className={cx("job-item")} key={index}>
                            <img src={avatar} alt={name} />
                            <div >
                                <h6 className={cx("mb-0")}>{name.slice(0, 20)}{name.length > 20 ? "..." : ""}</h6>
                                <div className="d-flex align-items-center">
                                    <small className={cx("fw-2")}>{you}{message.slice(0, 25)}{message.length > 25 ? "..." : ""}</small>
                                    <i className={cx("fa-solid fa-circle", "icon-time")} ></i>
                                    <small className={cx("fw-2")}>{sentTime}</small>
                                </div>
                            </div>
                        </Link>
                    )
                })}
            </div>
        </div>
    );
}

export default Sidebar;
