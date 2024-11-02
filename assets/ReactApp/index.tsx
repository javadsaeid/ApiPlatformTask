import React from "react";
import {createRoot} from "react-dom/client";

const App = () => {
    const ino : {title: string} = {title: 'welcome to my app'}
    return (
        <div>
            <h1>{ino.title}</h1>
            <form>
                <label htmlFor="username">Username:</label>
                <input type="text" id="username" name="_username" required/>
                <label htmlFor="password">Password:</label>
                <input type="password" id="password" name="_password" required/>
                <button type="submit">login</button>
            </form>
        </div>
    );
}


const customerRoot = document.getElementById('app-root');
createRoot(customerRoot).render(<App/>)