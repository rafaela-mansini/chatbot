import { FiSend } from 'react-icons/fi';
import './style.css';

const SendMessage = () => {
    return(
        <>
            <form className="form">
                <input type="text" name="name" placeholder='Send your text here...' />
                <button><FiSend /></button>
            </form>
        </>
    )
}

export default SendMessage;