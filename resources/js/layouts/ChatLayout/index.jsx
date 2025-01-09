import classNames from "classnames/bind";
import styles from "./ChatLayout.module.scss";
import Sidebar from "@/layouts/partials/sidebar";



const cx = classNames.bind(styles);

function ChatLayout() {
    return (
        <div className={cx("container-fluid")}>
            <div className={cx("row")}>
                {/* Sidebar */}
                <Sidebar />
                {/* Main Content */}
                <div className={cx("col-md-7", "content")}>
                    <h4 className={cx("text-center")}>New way to follow your chance. <span className={cx("text-success")}>More engage, more success</span></h4>
                    <div className={cx("no-chat", "text-center")}>
                        <img src="https://via.placeholder.com/100" alt="No Chat" />
                        <p className={cx("text-muted")}>Bạn không có cuộc trò chuyện nào...</p>
                    </div>
                </div>
                {/* Job List */}
                <div className={cx("col-md-3", "p-3")}>
                    <h5 className={cx("mb-3")}>Tin tuyển dụng đã ứng tuyển</h5>
                    <div className={cx("jobs-list")}>
                        <div className={cx("job-item")}>
                            <img src="https://via.placeholder.com/40" alt="Company Logo" />
                            <div>
                                <h6 className={cx("mb-0")}>Symfony PHP Dev</h6>
                                <small>Công ty TNHH...</small>
                            </div>
                            <button className={cx("btn", "btn-success", "btn-sm")}>Nhắn tin</button>
                        </div>
                        <div className={cx("job-item")}>
                            <img src="https://via.placeholder.com/40" alt="Company Logo" />
                            <div>
                                <h6 className={cx("mb-0")}>Intern PHP Dev</h6>
                                <small>Công ty Cổ phần...</small>
                            </div>
                            <button className={cx("btn", "btn-success", "btn-sm")}>Nhắn tin</button>
                        </div>
                        {/* Add more job items as needed */}
                    </div>
                </div>
            </div>
        </div>

    );
}

export default ChatLayout;
