
const buildMessage = (message, sender) =>{
    const date = new Date();
    const newMessage = {
        'sender': sender,
        'message': message,
        'date': date.getHours()+':'+date.getMinutes()
    }

    return newMessage;
}

export default buildMessage;