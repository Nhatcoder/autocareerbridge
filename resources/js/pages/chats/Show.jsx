import { ChatProvider } from "@/contexts/chat-context";

import ChatLayout from "@/layouts/ChatLayout";
import Content from '@/components/Content';

export default function Index({ company }) {
    return (
        <ChatProvider company={company} >
            <ChatLayout>
                <Content></Content>
            </ChatLayout>
        </ChatProvider>
    );
}
