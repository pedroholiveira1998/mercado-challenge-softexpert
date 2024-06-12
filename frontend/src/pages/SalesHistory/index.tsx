import { useEffect, useState } from 'react'
import api from '@lib/api'
import { toast } from 'react-toastify'
import SalesCard from './Card/SalesCard'

const SalesHistoryPage = () => {
  const [isLoading, setIsLoading] = useState(null)
  const [sales, setSales] = useState([])

  const fetchSales = async () => {
    setIsLoading(true)
    try {
      const response = await api.get('/api/sale')
      setSales(response.data?.sales)
    } catch (error) {
      toast.error('Erro ao buscar dados.')
      console.error('Error fetching data:', error)
    } finally {
      setIsLoading(false)
    }
  }

  useEffect(() => {
    fetchSales()
  }, [])

  return <SalesCard sales={sales} />
}

export default SalesHistoryPage
