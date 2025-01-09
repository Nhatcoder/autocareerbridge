import classNames from "classnames/bind";
import styles from "./Sidebar.module.scss";

const cx = classNames.bind(styles);

function Sidebar() {
    return (
        <div className={cx("col-md-3", "sidebar", "border-right", "p-3")}>
            <div className={cx("top_sidebar d-flex justify-content-between align-items-center")}>
                <div className={cx("logo")}>
                    <img src="clients/images/header/logo2.png" alt="Logo"
                        title="Grace Church" />
                </div>

                <div className={cx("action", "d-flex")}>
                    <button className={cx("action__button--home")}>Về trang chủ</button>
                    <button className={cx("btn btn-success btn-sm")}>😂</button>
                </div>
            </div>
            <input type="text" className={cx("form-control mb-3")} placeholder="Tên công ty, tên nhà tuyển dụng..." />
            <img src="https://via.placeholder.com/300x150" className={cx("img-fluid mb-3")} alt="Ad" />
            <p className={cx("text-muted")}>Kết nối sâu hơn với bộ Sticker</p>
        </div>
    );
}

export default Sidebar;
