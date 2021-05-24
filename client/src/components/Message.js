import { DisappearedLoading } from 'react-loadingg';
import './style.css';

const Message = ({ sender, message, date }) => {

    return(
        <div className={sender}>
            {sender == "bot" && !message &&
                <span className='load'><DisappearedLoading size='small' color='#888888' style={{'position': 'relative', 'height': '30px'}} /></span>
            }
            <div className="message"> {message} </div>
            <div className="time"> {date} </div>
        </div>
    )
}

export default Message;