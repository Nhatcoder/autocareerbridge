import * as historyFileService from "@/apiServices/historyFileService";
import { useChat } from "@/contexts/chat-context";
import { roleUser } from "@/constants";
import classNames from "classnames/bind";
import styles from "./User.module.scss";

const cx = classNames.bind(styles);

function User() {
    const { data, setImages, setLoading, setFiles } = useChat();
    const receiver = data?.receiver || [];
    const user = data?.user;
    const checkRole = roleUser.includes(user?.role);

    const handleHistoryFileToggle = () => {
        const jobApplyList = document.querySelector(".job_apply_list");
        const historyFile = document.querySelector(".history_file");

        jobApplyList?.classList.toggle("d-none");
        historyFile?.classList.toggle("d-none");

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
    }

    return (
        (<>
            <div className={cx("user", "d-flex justify-content-between", "align-items-center")}>
                <div className={cx("user__info", "d-flex justify-content-center align-content-center")}>
                    <img className={cx("user__avatar")} src={window.location.origin + "/" + receiver?.avatar_path} alt="User" />
                    <div className="mt-1">
                        <h6 className={cx("mb-0")}>{receiver?.name}</h6>
                        <small>Hoạt động ngàn năm trước</small>
                    </div>
                </div>
                {checkRole != true ? (<div className={cx("user__action", "flex-end")} onClick={handleHistoryFileToggle}>
                    <i className="fa-solid fa-bars"></i>
                </div>) : ("")}
            </div>
        </>
        )
    );
}

export default User;
