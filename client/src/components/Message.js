import { DisappearedLoading } from 'react-loadingg';
import './style.css';

const Message = ({ sender }) => {

    const date = new Date();

    return(
        <div className={sender}>
            {sender == "bot" &&
                <span className='load'><DisappearedLoading size='small' color='#888888' style={{'position': 'relative', 'height': '30px'}} /></span>
            }
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