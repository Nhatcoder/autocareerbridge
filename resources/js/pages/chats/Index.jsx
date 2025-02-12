import { ChatProvider } from "@/contexts/chat-context";

import Content from '@/components/Content';
import ChatLayout from "@/layouts/ChatLayout";

export default function Index({data}) {
    return (
        <ChatProvider data={data}>
            <ChatLayout>
                <Content></Content>
            </ChatLayout>
        </ChatProvider>
    );
}
