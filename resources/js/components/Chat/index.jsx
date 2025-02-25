import Tippy from "@tippyjs/react";
import 'tippy.js/dist/tippy.css';
import classNames from "classnames/bind";
import styles from "./Chat.module.scss";

const cx = classNames.bind(styles);

function Chat({ ...props }) {
    const { user, receiver, message, nextMessage } = props;

    const checkUser = user.id == message.from_id
    const isSameSenderAsNext = nextMessage && nextMessage.from_id === message.from_id;
    const isLast = !isSameSenderAsNext;

    const date = new Date(message.sent_time);
    const formattedDate = `${date.toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' })} ${date.toLocaleString('en-GB', { hour: '2-digit', minute: '2-digit' })}`;

    const downloadFile = (filePath) => {
        saveAs(filePath);
    }

    return (
        <>
            {message.message.length > 0 &&
                <div className={cx("item_message", (checkUser ? "right" : "left"))}>
                    <div className={cx("box__message", {
                    })}>
                        {!checkUser && isLast && < img src={receiver?.avatar_path ? (receiver.avatar_path.startsWith('/') ? window.location.origin + receiver.avatar_path : receiver.avatar_path.startsWith('http') ? receiver.avatar_path : window.location.origin + "/" + receiver.avatar_path) : ''} alt="avt" className={cx("user_you")} />}

                        <Tippy
                            interactive={true}
                            delay={[0, 200]}
                            content={formattedDate}
                            placement={user ? "left" : "right"}
                        >
                            <div className={cx("message")}>
                                {message.message}
                            </div>
                        </Tippy>

                        <div className={cx("send")}>
                            {/* <div className={cx("send_pending")}><i className="fa-regular fa-circle-check"></i></div> */}
                            {/* <div className={cx("send_succes")}><i className="fa-solid fa-circle-check"></i></div> */}
                            {/* <img className={cx("user_seen")} src="https://i.pinimg.com/236x/45/15/88/451588be068e6a042693e33686ab6d34.jpg" alt="" /> */}
                        </div>
                    </div>
                </div>
            }

            {message?.attachments.length > 0 && (
                <Tippy
                    interactive={true}
                    delay={[0, 200]}
                    content={formattedDate}
                    placement={"top"}
                >
                    <div className={cx("attachments", (user.id == message.from_id ? "right" : "left"))}>
                        {message.attachments.map((file, index) => {
                            if (file.type == 1) {
                                return <div key={index} className={cx("attachment_image")}>
                                    <a href={file.file_path} data-fancybox="data-fancybox" data-caption={file.name || `Image ${i}`}>
                                        <img className={cx("attachment_image__img")} src={`${window.location.origin}${file.file_path || "/clients/images/no-image.jpg"}`} alt={file.name} />
                                    </a>
                                </div>
                            } else {
                                return <div key={index} onClick={() => downloadFile(`${window.location.origin}${file.file_path}`)} className={cx("attachment_file")}>
                                    <span className={cx("icon_file")}><i className="fa-regular fa-file-lines"></i></span>
                                    <span className={cx("attachment_file__name")} data-file={`${window.location.origin}${file.file_path}`}>{file.name}
                                    </span></div>
                            }
                        })}
                    </div>
                </Tippy>
            )}
        </>
    );
}

export default Chat;

