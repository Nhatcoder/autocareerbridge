import { createContext, useContext, useState } from "react";

const ChatContext = createContext();

export function ChatProvider({ children, ...props }) {
    const [images, setImages] = useState([]);
    const [files, setFiles] = useState([]);

    const value = {
        images,
        setImages,
        files,
        setFiles,
    };
    return (
        <ChatContext.Provider value={{ ...props, ...value }}>
            {children}
        </ChatContext.Provider>
    );
}

export const useChat = () => {
    const context = useContext(ChatContext);
    if (!context) {
        throw new Error("useChat phải được sử dụng trong ChatProvider");
    }
    return context;
};
