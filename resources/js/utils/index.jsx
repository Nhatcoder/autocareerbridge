export const formatDateChat = (date) => {
    const now = new Date();
    const dateObj = new Date(date);
    const diffTime = now - dateObj;
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    const diffHours = Math.floor((diffTime / (1000 * 60 * 60)) % 24);
    const diffMinutes = Math.floor((diffTime / (1000 * 60)) % 60);
    const dayOfWeek = dateObj.toLocaleString('vi-VN', { weekday: 'short' });

    // Nếu trong cùng ngày (chưa qua 24 giờ)
    if (diffDays < 1) {
        if (diffHours < 1) {
            if (diffMinutes < 1) {
                return "Vừa xong";
            }
            return `${diffMinutes} phút trước`;
        }
        return `${diffHours}:${diffMinutes < 10 ? '0' + diffMinutes : diffMinutes}`;
    }

    else if (diffDays < 7) {
        return `${diffHours}:${diffMinutes < 10 ? '0' + diffMinutes : diffMinutes} ${dayOfWeek}`;
    }
    else {
        return dateObj.toLocaleString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        });
    }
};

export const formatDate = (date) => {
    const now = new Date();
    const dateObj = new Date(date);
    const diffTime = Math.abs(now - dateObj);
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    const diffHours = Math.floor((diffTime / (1000 * 60 * 60)) % 24);
    const diffMinutes = Math.floor((diffTime / (1000 * 60)) % 60);
    const diffMonths = now.getMonth() - dateObj.getMonth() + 1 + (12 * (now.getFullYear() - dateObj.getFullYear()));
    const diffYears = now.getFullYear() - dateObj.getFullYear();

    if (diffDays < 1) {
        if (diffHours < 1) {
            if (diffMinutes < 1) {
                return "Vừa xong";
            }
            return `${diffMinutes} phút trước`;
        }
        return `${diffHours} giờ trước`;
    } else if (diffDays === 1) {
        return "Hôm qua";
    } else if (diffDays < 7) {
        return `${diffDays} ngày trước`;
    } else if (diffMonths < 12) {
        return `${diffMonths} tháng trước`;
    } else if (diffYears === 1) {
        return "Năm ngoái";
    } else if (diffYears > 1) {
        return `${diffYears} năm trước`;
    } else {
        return dateObj.toLocaleString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }
};
