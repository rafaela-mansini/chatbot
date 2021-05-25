import { useState, useEffect } from 'react';
import Message from '../../components/Message';
import SendMessage from '../../components/SendMessage';
import api from '../../services/server';
import buildMessage from '../../helper/buildMessage';
import './style.css';

const Chatbot = () => {
    const [messages, setMessages] = useState([]);
    const [operation, setOperation] = useState();
    const [listMessage, setListMessage] = useState([]);

    const setAllMessages = (message) => {
        setMessages([...messages, message]);
    }
    const searchMessageServer = async () => {
        if( messages.length && messages[messages.length-1].sender == 'customer'){

            const response = await api.get('messages', {
                params: {
                    expected_entries: messages[messages.length-1].message
                }
            });
            if(response.status === 200){
                const botMessage = await buildMessage(response.data.messages[0], 'bot');
                console.log(response.data);
                setAllMessages(botMessage);
                setListMessage(response.data.messages);
                setOperation(response.data.code);
            }
        }
    }

    useEffect(() => {
        const firstMessage = async () => {
            const response = await api.get('messages', {
                params: {
                    expected_entries: 'first_hello'
                }
            });

            if(response.status === 200 && response.data.success){
                const botMessage = await buildMessage(response.data.messages[0], 'bot');
                setAllMessages(botMessage);
            }
        }
        firstMessage();
    }, []);

    useEffect(() => {
        searchMessageServer();
    }, [messages]);

    return(
        <div className="chatbot-body">
            <h1 className="title">Chatbot</h1>
            <div className="chatbot">
                {messages &&(
                    messages.map((message, index) => (<Message sender={message.sender} message={message.message} date={message.date} key={message.message+index} />))
                )}
            </div>
            <div>
                <SendMessage setOperation={setOperation} setMessage={setAllMessages} />
            </div>
            
        </div>
    );
}

export default Chatbot