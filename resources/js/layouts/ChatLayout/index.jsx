import classNames from "classnames/bind";
import styles from "./ChatLayout.module.scss";

import Sidebar from "@/layouts/partials/Sidebar";
import RightSidebar from "@/layouts/partials/RightSidebar";
const cx = classNames.bind(styles);

function ChatLayout({ children }) {
    return (
        <div className={cx("container-fluid")}>
            <div className={cx("row")}>
                <Sidebar />
                {children}
                <RightSidebar />
            </div>
        </div >
    );
}

export default ChatLayout;
