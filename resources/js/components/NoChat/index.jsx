import classNames from "classnames/bind";
import styles from "./NoChat.module.scss";

const cx = classNames.bind(styles);
function NoChat() {
    return (
        <div className={cx("no_chat mt-5 pt-5")}>
            <div className={cx("no_chat__content", "text-center")}>
                <img className={cx("no_chat__img")} src={`${window.location.origin}/clients/images/no-chat.png`} alt="No Chat" />
                <p className={cx("text-muted")}>Bạn không có cuộc trò chuyện nào...</p>
            </div>
        </div>
    );
}

export default NoChat;
