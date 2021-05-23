import Message from '../../components/Message';
import SendMessage from '../../components/SendMessage';
import './style.css';

const Chatbot = () => {
    return(
        <div className="chatbot-body">
            <h1 className="title">Chatbot</h1>
            <div className="chatbot">
                <Message sender='bot' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='customer' />
                <Message sender='bot' />
            </div>
            <div>
                <SendMessage />
            </div>
            
        </div>
    );
}

export default Chatbot