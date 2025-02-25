import { useEffect } from 'react';
import { useChat } from "@/contexts/chat-context";
import classNames from "classnames/bind";
import styles from "./Job.module.scss";
import Tippy from "@tippyjs/react";
import { Link } from "@inertiajs/react";
import { useResponsive } from "@/contexts/ResponsiveContext";

const cx = classNames.bind(styles);
import 'tippy.js/dist/tippy.css';

function Job({ job }) {
    if (!job || !job['job']) {
        return null;
    }
    const { isTabletOrMobile } = useResponsive();

    const { data } = useChat();
    const { name, company, slug } = job['job'] || {};
    const { id, avatar_path, name: companyName } = company || {};
    const receiver = data?.receiver;

    const handleToggleChat = () => {
        if (isTabletOrMobile) {
            const newState = true;
            localStorage.setItem("boxChat", JSON.stringify(newState));
            refToggleSidebar.current.classList.add("d-none");
        }
    };

    return (
        <div className={cx("job-item", { active: id === receiver.id })}>
            <img
                src={avatar_path ? `${window.location.origin}/${avatar_path}` : "default-image-path.jpg"}
                alt={companyName}
            />
            <div>
                <Tippy
                    interactive={false}
                    delay={[0, 0]}
                    content={name || ""}
                    placement={"top"}
                    hideOnClick={false}
                    onClickOutside={() => {
                        const instance = Tippy.getInstance(this);
                        if (instance) {
                            instance.hide();
                        }
                    }}
                >
                    <h6 className={cx("name", "mb-0")}>
                        <a href={route('detailJob', { slug })} target="_blank" rel={name}>{name.length > 35 ? `${name.slice(0, 30)}...` : name}</a>
                    </h6>
                </Tippy>
                <Tippy
                    interactive={false}
                    delay={[0, 100]}
                    content={companyName || ""}
                    hideOnClick={false}
                    onClickOutside={() => {
                        const instance = Tippy.getInstance(this);
                        if (instance) {
                            instance.hide();
                        }
                    }}
                    placement={"top"}
                >
                    <small>{companyName || `${companyName.slice(0, 35)}${companyName.length > 35 ? "..." : ""}` || ""}</small>
                </Tippy>
            </div>
            <Link href={route('conversations', id)} className={cx("btn", "btn-primary", "btn-sm")} onClick={handleToggleChat}>Nhắn tin</Link>

        </div >
    );
}

export default Job;
