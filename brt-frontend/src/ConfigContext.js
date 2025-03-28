import React, { createContext, useContext } from 'react';

const ConfigContext = createContext();

export const useConfig = () => {
  return useContext(ConfigContext);
};

export const ConfigProvider = ({ children }) => {
  const config = {
    API_URL: process.env.REACT_APP_API_URL || "http://127.0.0.1:8000/api",
    API_URL_BRT: process.env.REACT_APP_API_URL_BRT || "http://127.0.0.1:8000/api/brts",
    TOKEN: localStorage.getItem("token")
  };

  return (
    <ConfigContext.Provider value={config}>
      {children}
    </ConfigContext.Provider>
  );
};
