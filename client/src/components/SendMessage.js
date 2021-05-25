import { useState, useEffect } from 'react';
import { FiSend } from 'react-icons/fi';
import api from '../services/server';
import buildMessage from '../helper/buildMessage';
import './style.css';

const SendMessage = ({ setOperation, setMessage }) => {
    const [messageCustomer, setMessageCustomer] = useState('');
    const handleMessage = (e) => setMessageCustomer(e.target.value);

    const submitMessage = async (e) => {
        e.preventDefault()
        const customerMessage = await buildMessage(messageCustomer, 'customer');
        setMessage(customerMessage);
        setMessageCustomer('');
    }
    
    return(
        <>
            <form className="form" onSubmit={submitMessage}>
                <input 
                    type="text"
                    name="message"
                    placeholder='Send your text here...'
                    onChange={handleMessage}
                    value={messageCustomer} />
                    
                <button type="submit">
                    <FiSend />
                </button>
            </form>
        </>
    )
}

export default SendMessage;