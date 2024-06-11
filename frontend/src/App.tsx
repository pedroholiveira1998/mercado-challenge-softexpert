import { useEffect } from 'react';
import api from '@lib/api';
// import React from 'react';

function App() {

  useEffect(() => {
    api.get('/api/productType')
      .then((response: { data: any; }) => {
        console.log(response.data);
      })
      .catch((error: any) => {
        console.error('Error fetching data:', error);
      });
  }, []);
  return (
    <h1> Hello World</h1>
  )
}

export default App
