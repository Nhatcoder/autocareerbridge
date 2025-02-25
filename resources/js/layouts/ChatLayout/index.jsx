import classNames from "classnames/bind";
import styles from "./ChatLayout.module.scss";

import Sidebar from "@/layouts/partials/Sidebar";
import RightSidebar from "@/layouts/partials/RightSidebar";
import Footer from "@/layouts/partials/Footer";

const cx = classNames.bind(styles);

function ChatLayout({ children }) {
    return (
        <div className={cx("container-fluid")}>
            <div className={cx("row")}>
                <Sidebar />
                {children}
                <RightSidebar />
                <Footer />
            </div>
        </div >
    );
}

export default ChatLayout;
