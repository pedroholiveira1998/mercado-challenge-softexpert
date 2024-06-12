import { Global } from '@emotion/react'
import globalStyles from '@styles/globalStyles'
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Navigate,
} from 'react-router-dom'
import Sidebar from '@components/Sidebar'
import ProductTypesPage from '@pages/ProductTypes'
import ProductsPage from '@pages/Products'
import SalesPage from '@pages/Sales'
import { ToastContainer } from 'react-toastify'
import SalesHistoryPage from '@pages/SalesHistory'

function App() {
  return (
    <>
      <Global styles={globalStyles} />
      <Router>
        <div style={{ display: 'flex' }}>
          <Sidebar />
          <div style={{ flexGrow: 1, padding: '20px' }}>
            <Routes>
              <Route path="/" element={<Navigate to="/vendas" />} />
              <Route path="/produtos" element={<ProductsPage />} />
              <Route path="/tipo-produtos" element={<ProductTypesPage />} />
              <Route path="/vendas" element={<SalesPage />} />
              <Route path="/historico-vendas" element={<SalesHistoryPage />} />
            </Routes>
          </div>
        </div>
      </Router>
      <ToastContainer />
    </>
  )
}

export default App
