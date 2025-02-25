import { ChatProvider } from "@/contexts/chat-context";
import { ResponsiveProvider } from "@/contexts/ResponsiveContext";
import Content from '@/components/Content';
import ChatLayout from "@/layouts/ChatLayout";

export default function Index({ data }) {
    return (
        <ResponsiveProvider>
            <ChatProvider data={data}>
                <ChatLayout>
                    <Content></Content>
                </ChatLayout>
            </ChatProvider>
        </ResponsiveProvider>
    );
}
