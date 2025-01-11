import classNames from "classnames/bind";
import styles from "./Sidebar.module.scss";

const cx = classNames.bind(styles);

function Sidebar() {
    return (
        <div className={cx("col-md-3", "sidebar", "border-right", "p-3")}>
            <div className={cx("top_sidebar d-flex justify-content-between align-items-center")}>
                <a href={route('home')} className={cx("logo")}>
                    <img src="clients/images/header/logo2.png" alt="Logo"
                        title="Autocareerbridge" />
                </a>

                <div className={cx("action", "d-flex")}>
                    <a href={route('home')} className={cx("action__button--home")}>Về trang chủ</a>
                    {/* <button className={cx("btn btn-success btn-sm")}>😂</button> */}
                </div>
            </div>

            <div className={cx("box-search")}>
                <div className={cx("icon")}> <i className="fa-solid fa-magnifying-glass" /></div>
                <input type="text" className={cx("search__company", "form-control mb-3")} placeholder="Tên công ty, tên nhà tuyển dụng..." />
            </div>

            <div className={cx("jobs-list")}>
                <div className={cx("job-item")}>
                    <img src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/company_logos/cong-ty-co-phan-phan-mem-vitex-viet-nam-612f11ca86189.jpg" alt="Company Logo" />
                    <div>
                        <h6 className={cx("mb-0")}>Symfony PHP Dev</h6>
                        <small>Công ty TNHH...</small>
                    </div>
                </div>
                <div className={cx("job-item")}>
                    <img src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/company_logos/cong-ty-co-phan-phan-mem-vitex-viet-nam-612f11ca86189.jpg" alt="Company Logo" />
                    <div>
                        <h6 className={cx("mb-0")}>Intern PHP Dev</h6>
                        <small>Công ty Cổ phần...</small>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Sidebar;
