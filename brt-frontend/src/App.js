import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { useConfig } from "./ConfigContext";
import { toast } from "react-toastify";

const App = () => {
    const { API_URL_BRT, TOKEN } = useConfig();
    const [brts, setBrts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchBRTs();
    }, []);

    const fetchBRTs = async () => {
        try {
            setLoading(true);
            const response = await axios.get(API_URL_BRT, {
                headers: { Authorization: `Bearer ${TOKEN}` },
            });
            setBrts(response.data);
        } catch (error) {
            setError("Error fetching BRTs. Please try again later.");
            console.error("Error fetching BRTs", error);
        } finally {
            setLoading(false);
        }
    };

    const deleteBRT = async (id) => {
        if (window.confirm("Are you sure you want to delete this BRT?")) {
            try {
                await axios.delete(`${API_URL_BRT}/${id}`, {
                    headers: { Authorization: `Bearer ${TOKEN}` },
                });
                toast.success("Deleting BRT Successful.");
                fetchBRTs();
            } catch (error) {
                console.error("Error deleting BRT", error);
                setError("Error deleting BRT. Please try again later.");
                toast.error("Error deleting BRT. Please try again later.");
            }
        }
    };

    return (
        <div className="container mt-5">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h1 className="text-primary">BRT Management</h1>
                <Link to="/create" className="btn btn-success">
                    <i className="bi bi-plus-circle"></i> Create BRT
                </Link>
            </div>

            {loading && <div className="alert alert-info text-center">Loading...</div>}

            {error && <div className="alert alert-danger text-center">{error}</div>}

            {Array.isArray(brts) && brts.length > 0 ? (
                <div className="table-responsive">
                    <table className="table table-bordered table-hover">
                        <thead className="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>BRT Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th className="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {brts.map((brt) => (
                                <tr key={brt.id}>
                                    <td>{brt.id}</td>
                                    <td>{brt.brt_code}</td>
                                    <td>{brt.reserved_amount} BLM</td>
                                    <td>
                                        <span className={`badge ${brt.status === 'active' ? 'bg-success' : 'bg-secondary'}`}>
                                            {brt.status}
                                        </span>
                                    </td>
                                    <td className="text-center">
                                        <Link to={`/edit/${brt.id}`} className="btn btn-sm btn-warning me-2">
                                            <i className="bi bi-pencil"></i> Edit
                                        </Link>
                                        <button
                                            onClick={() => deleteBRT(brt.id)}
                                            className="btn btn-sm btn-danger"
                                        >
                                            <i className="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            ) : (
                <div className="alert alert-warning text-center">No BRTs available.</div>
            )}
        </div>
    );
};

export default App;