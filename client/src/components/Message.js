import { useState } from 'react';
import './style.css';

const Message = ({ sender }) => {

    const date = new Date();

    return(
        <div className={sender}>
            <div className="message">
                Message {sender}
            </div>
            <div className="time">
                {date.getHours()}:{date.getMinutes()}
            </div>
        </div>
    )
}

export default Message;