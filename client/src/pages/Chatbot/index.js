import { useState, useEffect } from 'react';
import Message from '../../components/Message';
import SendMessage from '../../components/SendMessage';
import api from '../../services/server';
import './style.css';

const Chatbot = () => {
    const [messages, setMessages] = useState([]);

    useEffect(() => {
        const firstMessage = async () => {
            const response = await api.get('messages', {
                params: {
                    expected_entries: 'first_hello'
                }
            });

            if(response.status == 200 && response.data.success){
                const date = new Date();
                const newMessage = {
                    'sender': 'bot',
                    'message': response.data.messages[0],
                    'date': date.getHours()+':'+date.getMinutes()
                }
                setMessages([...messages, newMessage])
            }
        }
        firstMessage();
    }, []);

    return(
        <div className="chatbot-body">
            <h1 className="title">Chatbot</h1>
            <div className="chatbot">
                {messages &&(
                    messages.map((message) => (<Message sender={message.sender} message={message.message} date={message.date} key={message.message} />))
                )}
            </div>
            <div>
                <SendMessage />
            </div>
            
        </div>
    );
}

export default Chatbot