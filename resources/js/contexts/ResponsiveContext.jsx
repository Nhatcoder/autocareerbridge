import { createContext, useContext, useState } from "react";
import { useMediaQuery } from "react-responsive";

const ResponsiveContext = createContext();

export const ResponsiveProvider = ({ children }) => {
    const isBigScreen = useMediaQuery({ query: '(min-width: 1824px)' })
    const isDesktopOrLaptop = useMediaQuery({ query: '(min-width: 1224px)' })
    const isTabletOrMobile = useMediaQuery({ query: '(max-width: 1224px)' })

    const [boxChat, setBoxChat] = useState(false);

    const value = {
        isBigScreen,
        isDesktopOrLaptop,
        isTabletOrMobile,
        boxChat,
        setBoxChat
    }

    return (
        <ResponsiveContext.Provider value={{ ...value }}>
            {children}
        </ResponsiveContext.Provider>
    );
};

export const useResponsive = () => {
    const responsive = useContext(ResponsiveContext);
    if (!responsive) {
        throw new Error("useResponsive phải được sử dụng trong ChatProvider");
    }
    return responsive;
}
