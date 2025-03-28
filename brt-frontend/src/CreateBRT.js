import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useConfig } from "./ConfigContext";
import { toast } from "react-toastify";

const CreateBRT = () => {
    const { API_URL_BRT, TOKEN } = useConfig();
    const [reserved_amount, setReservedAmount] = useState("");
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        try {
            const response = await axios.post(
                API_URL_BRT, 
                { reserved_amount }, 
                { headers: { Authorization: `Bearer ${TOKEN}` } }
            );

            toast.success(`BRT Created: ${response.data.brt_code} - ${response.data.reserved_amount} BLM`);
            navigate("/brts");
        } catch (error) {
            console.error("Error creating BRT", error);
            toast.error("Failed to create BRT.");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="container mt-5">
            <div className="card shadow-lg p-4">
                <h2 className="text-center text-primary mb-4">Create BRT</h2>

                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label className="form-label fw-bold">Reserved Amount</label>
                        <input 
                            type="number" 
                            className="form-control" 
                            placeholder="Enter reserved amount" 
                            value={reserved_amount} 
                            onChange={(e) => setReservedAmount(e.target.value)} 
                            required 
                        />
                    </div>

                    <div className="d-flex justify-content-between">
                        <button type="submit" className="btn btn-success" disabled={loading}>
                            {loading ? (
                                <>
                                    <span className="spinner-border spinner-border-sm me-2"></span>
                                    Creating...
                                </>
                            ) : (
                                <>Create BRT</>
                            )}
                        </button>

                        <button type="button" className="btn btn-secondary" onClick={() => navigate("/brts")}>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default CreateBRT;