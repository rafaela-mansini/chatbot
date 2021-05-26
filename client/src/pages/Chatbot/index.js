import { useState, useEffect, useRef } from 'react';
import Message from '../../components/Message';
import SendMessage from '../../components/SendMessage';
import api from '../../services/server';
import buildMessage from '../../helper/buildMessage';
import './style.css';
import account from '../../helper/account';

const Chatbot = () => {
    const divChatbot = useRef(null);
    const [messages, setMessages] = useState([]);
    const [objectToSave, setObjectToSave] = useState([]);
    const [nextStep, setNextStep] = useState('');
    const [accessToken, setAccessToken] = useState('');
    const functionsServer = ['registerAccount', 'login', 'deposit', 'withdraw', 'balance'];

    const searchMessageServer = async (message) => {
        const response = await api.get('messages', {
            params: {
                expected_entries: message
            }
        });
        if(response.status === 200){
            const botMessage = await buildMessage(response.data.message, 'bot');
            setMessages([...messages, botMessage]);
            if(response.data.next_step !== null){
                setNextStep(response.data.next_step);
            }
        }
    }

    const saveMessageUser = async (message) => {
        
        if(nextStep){
            setObjectToSave([...objectToSave, message]);
        }
        const customerMessage = await buildMessage(message, 'customer');
        setMessages([...messages, customerMessage]);
    }

    const sendFunctionToServer = async (sendTo) => {
        switch (sendTo) {
            case 'registerAccount':
                registerAccount();
                break;
            case 'login':
                login();
                break;
            case 'deposit':
                deposit();
                break;
            case 'withdraw':
                withdraw();
                break;
            case 'balance':
                balance();
                break;
            default:
                break;
        }
        setNextStep('');
        setObjectToSave([]);
    }

    const registerAccount = async () => {

        const data = {
            "name": objectToSave[0],
            "email": objectToSave[1],
            "password": objectToSave[2],
            "password_confirmation": objectToSave[3]
        }
        const response = await api.post('register', data, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then((response) => {
            setAccessToken(response.data.access_token);
            setMessageBot(response.data.message);
        })
        .catch((error) => {
            setMessageBot(error.message);
        });

    }

    const login = async () => {
        const data = {
            "email": objectToSave[0],
            "password": objectToSave[1]
        }
        const response = await api.post('login', data, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then((response) => {
            setAccessToken(response.data.access_token);
            setMessageBot(response.data.message);
        })
        .catch((error) => {
            setMessageBot(error.message);
        });
    }

    const deposit = async () => {
        let currency = objectToSave[1].toLowerCase() == 'no' ? 'no' : objectToSave[1];
        const data = {
            "amount": objectToSave[0],
            "currency": currency
        }
        await api.put('transactions/deposit', data, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + accessToken
            }
        })
        .then((response) => {
            setMessageBot(response.data.data.message);
        })
        .catch((error) => {
            setMessageBot(error.message);
        });
    }

    const withdraw = async () => {
        let currency = objectToSave[1].toLowerCase() == 'no' ? 'no' : objectToSave[1];
        const data = {
            "amount": objectToSave[0],
            "currency": currency
        }
        await api.put('transactions/withdraw', data, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + accessToken
            }
        })
        .then((response) => {
            setMessageBot(response.data.data.message);
        })
        .catch((error) => {
            setMessageBot(error.message);
        });
    }

    const balance = async () => {
        await api.get('transactions/balance', {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + accessToken
            }
        })
        .then((response) => {
            setMessageBot(response.data.message);
        })
        .catch((error) => {
            setMessageBot(error.message);
        });
    }

    useEffect(() => {
        searchMessageServer('first_hello');
    }, []);

    useEffect(() => {
        if(messages.length && messages[messages.length-1].sender == 'customer'){
            
            if(nextStep){

                let existFunction = functionsServer.findIndex((func) => func === nextStep);
                
                if(existFunction === -1){
                    searchMessageServer(nextStep);                    
                }
                else{
                    setMessageBot('Please, wait...');
                    sendFunctionToServer(nextStep);
                }
            }
            else{
                searchMessageServer(messages[messages.length-1].message);
            }
        }

        const heightPage = divChatbot.current.scrollHeight;
        if (heightPage) {
            divChatbot.current.scrollTo(0, heightPage);
        }
    }, [messages]);

    const setMessageBot = async (message) => {
        const botMessage = await buildMessage(message, 'bot');
        setMessages([...messages, botMessage]);
    }






    // const [operation, setOperation] = useState();
    // const [listMessage, setListMessage] = useState([]);
    // const [stepsOperation, setStepsOperation] = useState();
    // const [awaitCustomer, setAwaitCustomer] = useState(false);

    // const setAllMessages = (message) => {
    //     setMessages([...messages, message]);
    // }
    // const searchMessageServer = async () => {
    //     if( messages.length && messages[messages.length-1].sender == 'customer'){

    //         const response = await api.get('messages', {
    //             params: {
    //                 expected_entries: messages[messages.length-1].message
    //             }
    //         });
    //         if(response.status === 200){
    //             const botMessage = await buildMessage(response.data.messages[0], 'bot');
    //             setAllMessages(botMessage);
    //             setListMessage(response.data.messages);
    //             setStepsOperation(response.data.bot_response);
    //             setOperation(response.data.code);
    //         }
    //     }
    // }

    // useEffect(() => {
    //     const firstMessage = async () => {
    //         const response = await api.get('messages', {
    //             params: {
    //                 expected_entries: 'first_hello'
    //             }
    //         });

    //         if(response.status === 200 && response.data.success){
    //             const botMessage = await buildMessage(response.data.messages[0], 'bot');
    //             setAllMessages(botMessage);
    //         }
    //     }
    //     firstMessage();
    // }, []);

    // useEffect(() => {
    //     if(!awaitCustomer){
    //         searchMessageServer();
    //     }
    //     else{

    //     }
    // }, [messages]);

    // useEffect(() => {
    //     if(operation === 'create_account'){
    //         setAwaitCustomer(true);
    //         const missingMessageList = listMessage.slice(1, listMessage.length);
    //         setListMessage(missingMessageList);


    //         console.log('missingMessageList', missingMessageList);
    //         // listMessage.forEach((message) => {
                
    //         //     alert(messages[messages.length-1].message);
    //         // });

    //         // account(listMessage, stepsOperation);
    //     }
    // }, [operation]);

    return(
        <div className="chatbot-body">
            <h1 className="title">Chatbot</h1>
            <div className="chatbot" ref={divChatbot}>
                {messages &&(
                    messages.map((message, index) => (<Message sender={message.sender} message={message.message} date={message.date} key={message.message+index} />))
                )}
            </div>
            <div>
                <SendMessage saveMessageUser={saveMessageUser}  />
                {/* <SendMessage setOperation={setOperation} setMessage={setAllMessages} /> */}
            </div>
            
        </div>
    );
}

export default Chatbot