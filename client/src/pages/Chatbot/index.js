import Message from '../../components/Message';
import './style.css';

const Chatbot = () => {
    return(
        <div className="chatbot-body">
            <h1 className="title">Chatbot</h1>
            <div className="chatbot">
                <Message sender='bot' />
                <Message sender='customer' />
            </div>
        </div>
    );
}

export default Chatbot