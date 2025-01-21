import classNames from "classnames/bind";
import styles from "./Job.module.scss";
import Tippy from "@tippyjs/react";
import 'tippy.js/dist/tippy.css';

import { Link } from "@inertiajs/react";

const cx = classNames.bind(styles);

function Job({ job }) {
    if (!job || !job['job']) {
        return null;
    }

    const { name, company } = job['job'] || {};
    const { id, avatar_path, name: companyName } = company || {};

    return (
        <div className={cx("job-item")}>
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
                        {name ? `${name.slice(0, 35)}${name.length > 35 ? "..." : ""}` : "Job Name"}
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
            <Link href={route('conversations', id)} className={cx("btn", "btn-primary", "btn-sm")}>Nhắn tin</Link>

        </div>
    );
}

export default Job;
