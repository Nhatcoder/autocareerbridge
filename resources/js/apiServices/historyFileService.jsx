import axios from 'axios';

export const historyFile = async (receiverId) => {
    try {
        const res = await axios.get(route('historyFile'), {
            params: {
                id: receiverId
            }
        });
        return res.data;
    } catch (error) {
        console.error("Error:", error);
        throw error;
    }
}
