import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useConfig } from "./ConfigContext";

const Login = () => {
    const { API_URL } = useConfig();
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        setError(null); // Clear previous errors

        try {
            const response = await axios.post(`${API_URL}/login`, { email, password });
            localStorage.setItem("token", response.data.token);
            navigate("/brts");
        } catch (error) {
            setError("Invalid email or password");
        }
    };

    return (
        <div className="container d-flex justify-content-center align-items-center vh-100">
            <div className="card shadow p-4" style={{ width: "400px" }}>
                <h2 className="text-center mb-4">Login</h2>

                {error && <div className="alert alert-danger">{error}</div>}

                <form onSubmit={handleLogin}>
                    <div className="mb-3">
                        <label className="form-label">Email</label>
                        <input
                            type="email"
                            className="form-control"
                            placeholder="Enter your email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </div>

                    <div className="mb-3">
                        <label className="form-label">Password</label>
                        <input
                            type="password"
                            className="form-control"
                            placeholder="Enter your password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            required
                        />
                    </div>

                    <button type="submit" className="btn btn-primary w-100">Login</button>
                </form>

                <p className="mt-3 text-center">
                    Don't have an account? <a href="/register" className="btn btn-link">Register</a>
                </p>
            </div>
        </div>
    );
};

export default Login;