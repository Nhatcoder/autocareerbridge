
import Tippy from "@tippyjs/react";
import 'tippy.js/dist/tippy.css';

import classNames from "classnames/bind";
import styles from "./Chat.module.scss";


const cx = classNames.bind(styles);

function Chat(data, user) {
    return (
        // <div className={cx("item_message", (user ? "right" : ""))}>
        <div className={cx("item_message", (user ? "" : ""))}>
            <div className={cx("box__message")}>
                {/* Bạn chat thêm avt */}
                <img src="https://i.pinimg.com/236x/45/15/88/451588be068e6a042693e33686ab6d34.jpg" alt="" className={cx("user_you")} />
                <Tippy
                    interactive={true}
                    delay={[0, 200]}
                    content="00:03 11/01/2025"
                    placement= {user ? "left" : "right"}
                >
                    <p className={cx("message")}>Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.Quo ex voluptatem eaque tempora quos facere.</p>
                </Tippy>

                <div className={cx("send")}>
                    {/* <div className={cx("send_pending")}><i className="fa-regular fa-circle-check"></i></div> */}
                    {/* <div className={cx("send_succes")}><i className="fa-solid fa-circle-check"></i></div> */}
                    {/* <img className={cx("user_seen")} src="https://i.pinimg.com/236x/45/15/88/451588be068e6a042693e33686ab6d34.jpg" alt="" /> */}
                </div>
            </div>
        </div>

    );
}

export default Chat;
