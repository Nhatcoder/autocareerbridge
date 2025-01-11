import classNames from "classnames/bind";
import styles from "./JobList.module.scss";

const cx = classNames.bind(styles);

function JobList() {
    return (
        <div className={cx("col-md-3", "p-3", "border-left")}>
            <h5 className={cx("mb-3", "fs-6", "text-uppercase")}>Tin tuyển dụng đã ứng tuyển</h5>
            <div className={cx("jobs-list")}>
                <div className={cx("job-item")}>
                    <img src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/company_logos/cong-ty-co-phan-phan-mem-vitex-viet-nam-612f11ca86189.jpg" alt="Company Logo" />
                    <div>
                        <h6 className={cx("mb-0")}>Symfony PHP Dev</h6>
                        <small>Công ty TNHH...</small>
                    </div>
                    <button className={cx("btn", "btn-primary", "btn-sm")}>Nhắn tin</button>
                </div>
                <div className={cx("job-item")}>
                    <img src="https://cdn-new.topcv.vn/unsafe/https://static.topcv.vn/company_logos/cong-ty-co-phan-phan-mem-vitex-viet-nam-612f11ca86189.jpg" alt="Company Logo" />
                    <div>
                        <h6 className={cx("mb-0")}>Intern PHP Dev</h6>
                        <small>Công ty Cổ phần...</small>
                    </div>
                    <button className={cx("btn", "btn-primary", "btn-sm")}>Nhắn tin</button>
                </div>
                {/* Add more job items as needed */}
            </div>
        </div>
    );
}

export default JobList;
