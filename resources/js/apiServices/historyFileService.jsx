import axios from 'axios';

export const historyFile = async (receiverId) => {
    try {
        const res = await axios.get(route('historyFile', receiverId));
        return res.data;
    } catch (error) {
        console.error("Error:", error);
        throw error;
    }
}
export const historyImage = async (receiverId) => {
    try {
        const res = await axios.get(route('historyImage', receiverId));
        return res.data;
    } catch (error) {
        console.error("Error:", error);
        throw error;
    }
}
