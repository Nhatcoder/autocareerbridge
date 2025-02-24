import { useState, useEffect } from "react";
import InfiniteScroll from "react-infinite-scroll-component";
import { groupByMonthAndYear } from "@/utils";
import { ROLE_USER } from "@/constants";
import { useChat } from "@/contexts/chat-context";

import Job from "@/components/Job";
import Loader from "@/components/Loader";
import { Fancybox } from "@fancyapps/ui";
import { saveAs } from 'file-saver';

import classNames from "classnames/bind";
import styles from "./RightSidebar.module.scss";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

const cx = classNames.bind(styles);

function RightSidebar() {
    const [hasMoreFile, setMoreFile] = useState(true);
    const [currentPage, setCurrentPage] = useState(2);
    const [hasMoreImage, setMoreImage] = useState(true);
    const [currentPageImage, setCurrentPageImage] = useState(2);
    const [file, setFile] = useState([]);
    const [image, setImage] = useState([]);

    const { data, loading, images, files } = useChat();
    const jobApply = data?.getUserApplyJob;
    const dataImages = images?.data;
    const dataFiles = files?.data;
    const user = data?.user;
    const checkRole = ROLE_USER.includes(user?.role);

    const groupedData = groupByMonthAndYear(image);

    useEffect(() => {
        if (dataFiles || dataImages) {
            setFile(dataFiles);
            setImage(dataImages);
        }
    }, [dataFiles, dataImages]);

    const handleScrollFile = async () => {
        try {
            const response = await axios.get(`${files.path}?page=${currentPage}`);
            const newData = response.data.data;

            setFile((prevItems) => [...prevItems, ...newData.data]);
            setCurrentPage(currentPage + 1);

            if (currentPage >= files.last_page) {
                setMoreFile(false);
            }
        } catch (error) {
            console.error(error);
        }
    }

    const handleScrollImage = async () => {
        try {
            const response = await axios.get(`${images.path}?page=${currentPageImage}`);
            const newData = response.data.data;

            setImage((prevItems) => [...prevItems, ...newData.data]);
            setCurrentPageImage(currentPageImage + 1);

            if (currentPageImage >= images.last_page) {
                setMoreImage(false);
            }
        } catch (error) {
            console.error(error);
        }
    }

    Fancybox.bind("[data-fancybox]");

    const downloadFile = (filePath) => {
        saveAs(filePath);
    }

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
                            <button className={cx("btn_attachment", "nav-link", "active")} id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Tệp hình ảnh</button>
                            <button className={cx("btn_attachment", "nav-link")} id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">File</button>
                        </div>
                    </nav>
                    <div className="tab-content" id="nav-tabContent">
                        <div className="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabIndex={0}>
                            <div className={cx("attachment_image")} id="scrollableImage">
                                <InfiniteScroll
                                    dataLength={groupedData}
                                    next={handleScrollImage}
                                    hasMore={hasMoreImage}
                                    style={{ overflow: 'hidden' }}
                                    loader={<div className={cx("text-center")}><Loader /></div>}
                                    scrollableTarget="scrollableImage"
                                    scrollThreshold={0.6}
                                >
                                    {Object.keys(groupedData).map((groupKey, index) => (
                                        <div key={index} className={cx("mb-3")}>
                                            <h6 className={cx("fs-6 mt-2", "text-uppercase")}>{groupKey}</h6>

                                            <div className={cx("list_images")}>
                                                {groupedData[groupKey].map((item, i) => (
                                                    <div key={i} className={cx("item_image")}>
                                                        <a href={item.file_path} data-fancybox="data-fancybox" data-caption={item.name || `Image ${i}`}>
                                                            <img
                                                                className={cx('item__image_img')}
                                                                src={item.file_path}
                                                                alt={item.name || `Image ${i}`}
                                                            />
                                                        </a>

                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    ))}
                                </InfiniteScroll>
                            </div>
                        </div>

                        <div className="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabIndex={0}>
                            {file && file.length > 0 ? (
                                <ul className={cx("list_files")} id="scrollableFiles">
                                    <InfiniteScroll
                                        dataLength={file.length}
                                        next={handleScrollFile}
                                        hasMore={hasMoreFile}
                                        style={{ overflow: 'hidden' }}
                                        loader={<div className={cx("text-center")}><Loader /></div>}
                                        scrollableTarget="scrollableFiles"
                                        scrollThreshold={0.8}
                                    >
                                        {file.map((file, i) => (
                                            <li key={i} onClick={() => downloadFile(file.file_path)} className={cx("item_file")}>
                                                <span className={cx("icon_file")}>
                                                    <i className="fa-regular fa-file-lines"></i>
                                                </span>
                                                <span className={cx("name_file")}>
                                                    {file.name}
                                                </span>
                                            </li>
                                        ))}
                                    </InfiniteScroll>
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
