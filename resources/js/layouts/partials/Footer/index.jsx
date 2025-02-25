import { useEffect, useState } from "react";
import { useResponsive } from "@/contexts/ResponsiveContext";
import { useChat } from "@/contexts/chat-context";
import { ROLE_USER } from "@/constants";

import classNames from "classnames/bind";
import styles from "./Footer.module.scss";

const cx = classNames.bind(styles);
function Footer() {
    const { isTabletOrMobile } = useResponsive();
    const { data } = useChat();
    const [footerMobile, setFooterMobile] = useState(false);
    const [tabActive, setTabActive] = useState('conversation');

    const { user } = data;
    const checkRole = ROLE_USER.includes(user?.role);

    useEffect(() => {
        if (isTabletOrMobile) {
            const storedBoxChat = localStorage.getItem("boxChat");
            if (storedBoxChat !== null) {
                const isBoxChatOpen = JSON.parse(storedBoxChat);
                setFooterMobile(!isBoxChatOpen);
                return;
            }
            setFooterMobile(true);
        }
    }, [isTabletOrMobile]);

    const handleTonggleBottomTab = (target) => {
        const sidebar = document.querySelector(".sidebar");
        const rightSidebar = document.querySelector(".right_sidebar");
        setTabActive(target);
        rightSidebar.classList.toggle("d-none");
        sidebar.classList.toggle("d-none");
    }
    return (
        <>
            {
                isTabletOrMobile && footerMobile && !checkRole &&
                <div className={cx("bottom-tab-mobile")} >
                    <div className={cx("d-flex justify-content-center p-3")}>
                        <div className={cx("mx-5 text-center", "bottom_tab", { active: tabActive == "conversation" })} onClick={() => handleTonggleBottomTab("conversation")}>
                            <i className={cx("d-block fab fa-facebook-messenger")} style={{ fontSize: 20 }} />
                            <p className={cx("mb-0 mt-2 text-sm")}>Chat</p>
                        </div>
                        <div className={cx("mx-5 text-center", "bottom_tab", { active: tabActive == "jobapply" })} onClick={() => handleTonggleBottomTab("jobapply")}>
                            <i className={cx("d-block fas fa-briefcase")} style={{ fontSize: 20 }} />
                            <p className={cx("mb-0 mt-2 text-sm")}>Đã ứng tuyển</p>
                        </div>
                    </div>
                </div>
            }
        </>
    )
}

export default Footer;
