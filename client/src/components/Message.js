import './style.css';

const Message = ({ sender, message, date }) => {

    return(
        <div className={sender}>
            <div className="message"> {message} </div>
            <div className="time"> {date} </div>
        </div>
    )
}

export default Message;