import { roleUser } from "@/constants";
import { useChat } from "@/contexts/chat-context";
import classNames from "classnames/bind";
import styles from "./RightSidebar.module.scss";
import Job from "@/components/Job";

const cx = classNames.bind(styles);

function RightSidebar() {
    const { data, images, files } = useChat();
    const jobApply = data?.getUserApplyJob;
    const dataImages = images?.data;
    const dataFiles = files?.data;
    const user = data?.user;
    const checkRole = roleUser.includes(user?.role);

    return (
        <div className={cx("col-md-3", "p-3", "border-left")}>
            {checkRole != true ? (<div className={cx("job_apply_list")}>
                <h5 className={cx("mb-3", "fs-6", "text-uppercase")}>Tin tuyển dụng đã ứng tuyển</h5>
                <div className={cx("jobs-list")}>
                    {jobApply && jobApply.map((job) => (
                        <Job key={job.id} job={job} />
                    ))}
                </div>
            </div>) : ("")}

            <div className={cx("history_file", { "d-none": !checkRole })}>
                <h5 className={cx("mb-3", "fs-6", "text-uppercase")}>Quản lý file</h5>
                <div>
                    <nav>
                        <div className={cx("nav", "nav-tabs")} id="nav-tab" role="tablist">
                            <button className={cx("nav-link", "active")} id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Tệp hình ảnh</button>
                            <button className={cx("nav-link")} id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">File</button>
                        </div>
                    </nav>
                    <div className="tab-content" id="nav-tabContent">
                        <div className="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabIndex={0}>
                            {dataImages && Object.keys(dataImages).length > 0 ? (
                                Object.keys(dataImages).map((monthKey, index) => {
                                    const imageMoth = dataImages[monthKey];
                                    return (
                                        <div key={index} className={cx("mb-3")}>
                                            <h6 className={cx("fs-6 mt-2", "text-uppercase")}>
                                                {`${new Date(imageMoth[0].created_at).toLocaleString('default', { month: 'long' })} / ${new Date(imageMoth[0].created_at).getFullYear()}`}
                                            </h6>
                                            <div className={cx("list_images")}>
                                                {imageMoth.map((image, i) => (
                                                    <div key={i} className={cx("item_image")}>
                                                        <img
                                                            className={cx('item__image_img')}
                                                            src={image.file_path}
                                                            alt={image.name || "Image"}
                                                        />
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    );
                                })
                            ) :
                                (
                                    <div className={cx("no_data")}>
                                        <h6 className={cx("fs-6 mt-2", "text-uppercase")}>Không có dữ liệu</h6>
                                    </div>
                                )}

                        </div>
                        <div className="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabIndex={0}>
                            {dataFiles && dataFiles.length > 0 ? (
                                <ul className={cx("list_files")}>
                                    {dataFiles.map((file, i) => (
                                        <li key={i} className={cx("item_file")}>
                                            <span className={cx("icon_file")}>
                                                <i className="fa-regular fa-file-lines">
                                                </i>
                                            </span>
                                            <span className={cx("name_file")}>
                                                {file.name}
                                            </span>
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <div className={cx("no_data")}>
                                    <h6 className={cx("fs-6 mt-2", "text-uppercase")}>Không có dữ liệu</h6>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

            </div>
        </div >
    );
}

export default RightSidebar;
