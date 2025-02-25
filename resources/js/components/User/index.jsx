import { useEffect } from "react";
import Tippy from "@tippyjs/react";
import 'tippy.js/dist/tippy.css';

import * as historyFileService from "@/apiServices/historyFileService";
import { useChat } from "@/contexts/chat-context";
import { useResponsive } from "@/contexts/ResponsiveContext";
import { ROLE_USER } from "@/constants";
import classNames from "classnames/bind";
import styles from "./User.module.scss";

const cx = classNames.bind(styles);

function User({ online, refContainerChat }) {
    const { data, setImages, setLoading, setFiles } = useChat();
    const { isTabletOrMobile } = useResponsive();

    const user = data?.user || [];
    const receiver = data?.receiver || [];
    const checkRole = ROLE_USER.includes(user?.role);

    useEffect(() => {
        if (receiver?.id) {
            setLoading(true);
            const fetchData = async () => {
                try {
                    const [attachmentFiles, attachmentImage] = await Promise.all([
                        historyFileService.historyFile(receiver.id),
                        historyFileService.historyImage(receiver.id)
                    ]);
                    setImages(attachmentImage.data);
                    setFiles(attachmentFiles.data);
                } catch (error) {
                    console.log('Error fetching history:', error);
                } finally {
                    setLoading(false);
                }
            }
            fetchData();
        }
    }, [receiver?.id]);

    const handleHistoryFileToggle = () => {
        const jobApplyList = document.querySelector(".job_apply_list");
        const historyFile = document.querySelector(".history_file");
        const rightSidebar = document.querySelector(".right_sidebar");

        jobApplyList?.classList.toggle("d-none");
        checkRole ? historyFile?.classList.remove("d-none") : historyFile?.classList.toggle("d-none");

        if (jobApplyList?.classList.contains("d-none")) {
            try {
                const handleHistory = async () => {
                    try {
                        setLoading(true);
                        const [attachmentFiles, attachmentImage] = await Promise.all([
                            historyFileService.historyFile(receiver.id),
                            historyFileService.historyImage(receiver.id)
                        ]);
                        setImages(attachmentImage.data);
                        setFiles(attachmentFiles.data);
                    } catch (error) {
                        console.log('Error fetching history:', error);
                    } finally {
                        setLoading(false);
                    }
                }
                handleHistory()
            } catch (error) {
                console.log(error);
            }
        }

        if (isTabletOrMobile) {
            rightSidebar?.classList.toggle("d-none");
            refContainerChat?.current?.classList.toggle("d-none");
        }

    }

    const handleBackHome = () => {
        const storedBoxChat = localStorage.getItem("boxChat");
        if (storedBoxChat !== null) {
            const isBoxChatOpen = JSON.parse(storedBoxChat);
            localStorage.setItem("boxChat", JSON.stringify(!isBoxChatOpen));
            refContainerChat.current.classList.add("d-none")
        }

        window.location.reload();
    }

    return (
        (<>
            <div className={cx("user", "d-flex justify-content-between", "align-items-center")}>
                <div className={cx("user__info", "d-flex justify-content-center align-content-center")}>
                    {isTabletOrMobile && <button onClick={handleBackHome} className={cx("btn_back")}>
                        <i className="fa-solid fa-arrow-left" />
                    </button>}
                    <img className={cx("user__avatar")} src={receiver?.avatar_path ? (receiver.avatar_path.startsWith('/') ? window.location.origin + receiver.avatar_path : receiver.avatar_path.startsWith('http') ? receiver.avatar_path : window.location.origin + "/" + receiver.avatar_path) : ''} alt="User" />
                    <div className="mt-1">
                        <h6 className={cx("mb-0")}>{receiver?.name || receiver?.user_name}</h6>
                        <small>{online ? "Đang hoạt động" : "Không hoạt động"}</small>
                    </div>
                </div>
                {/* {checkRole != true ? (<div className={cx("user__action", "flex-end")} onClick={handleHistoryFileToggle}>
                    <Tippy
                        interactive={false}
                        delay={[0, 100]}
                        content={"File"}
                        placement={"top"}
                        hideOnClick={false}
                    >
                        <i className="fa-solid fa-bars"></i>
                    </Tippy>
                </div>) : ("")} */}

                <div className={cx("user__action", "flex-end")} onClick={handleHistoryFileToggle}>
                    <Tippy
                        interactive={false}
                        delay={[0, 100]}
                        content={"File"}
                        placement={"top"}
                        hideOnClick={false}
                    >
                        <i className="fa-solid fa-bars"></i>
                    </Tippy>
                </div>
            </div >
        </>
        )
    );
}

export default User;
