import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import { useConfig } from "./ConfigContext";
import { toast } from "react-toastify";

const EditBRT = () => {
    const { API_URL_BRT, TOKEN } = useConfig();
    const { id } = useParams();
    const navigate = useNavigate();
    const [reserved_amount, setReservedAmount] = useState("");

    useEffect(() => {
        axios
            .get(`${API_URL_BRT}/${id}`, {
                headers: { Authorization: `Bearer ${TOKEN}` },
            })
            .then((res) => setReservedAmount(res.data.reserved_amount))
            .catch((err) => {
                console.error("Error fetching BRT details", err);
                toast.error("Failed to load BRT details.");
            });
    }, [id]);

    const handleUpdate = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.put(
                `${API_URL_BRT}/${id}`,
                { reserved_amount },
                {
                    headers: { Authorization: `Bearer ${TOKEN}` },
                }
            );
            toast.success(`BRT Updated: ${response.data.brt_code} - ${response.data.reserved_amount} BLM`);
            navigate("/brts");
        } catch (error) {
            console.error("Error updating BRT", error);
            toast.error("Failed to update BRT. Please try again.");
        }
    };

    return (
        <div className="container mt-5">
            <div className="card shadow-lg p-4">
                <h2 className="text-center text-primary mb-4">Edit BRT</h2>
                <form onSubmit={handleUpdate}>
                    <div className="mb-3">
                        <label className="form-label fw-bold">Reserved Amount (BLM)</label>
                        <input
                            type="number"
                            className="form-control"
                            value={reserved_amount}
                            onChange={(e) => setReservedAmount(e.target.value)}
                            required
                        />
                    </div>
                    <div className="d-flex justify-content-between">
                        <button type="button" className="btn btn-secondary" onClick={() => navigate("/brts")}>
                            Cancel
                        </button>
                        <button type="submit" className="btn btn-primary">
                            Update BRT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default EditBRT;