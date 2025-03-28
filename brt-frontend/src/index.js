import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import App from "./App";
import CreateBRT from "./CreateBRT";
import EditBRT from "./EditBRT";
import Login from "./Login";
import Register from "./Register";
import { ConfigProvider } from './ConfigContext';
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  <ConfigProvider>
  <Router>
    <ToastContainer position="top-right" autoClose={3000} />
    <Routes>
      <Route path="/brts" element={localStorage.getItem("token") ? <App /> : <Navigate to="/login" />} />
      <Route path="/register" element={<Register />} />
      <Route path="/login" element={<Login />} />
      <Route path="/create" element={<CreateBRT />} />
      <Route path="/edit/:id" element={<EditBRT />} />
    </Routes>
  </Router>
  </ConfigProvider>
);

/**

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();

*/
