import { useEffect, useState } from 'react'
import Header from './Components/Header'
import ProductSearch from './Components/ProductSearch'
import { toast } from 'react-toastify'
import api from '@lib/api'

const SalesPage = () => {
  const [products, setProducts] = useState([])
  const [isLoading, setIsLoading] = useState(false)
  const [cartItems, setCartItems] = useState([])

  const handleAddToCart = (productId, quantityStr) => {
    const productToAdd = products.find((product) => product.id === productId)
    const quantity = parseInt(quantityStr)

    setCartItems((prevState) => [
      ...prevState,
      { ...productToAdd, quantity: quantity },
    ])
  }

  const handleRemoveFromCart = (productId) => {
    setCartItems((prevState) =>
      prevState.filter((item) => item.id !== productId),
    )
  }

  const submitSale = async (cartItems) => {
    const saleDate = new Date().toISOString().split('T')[0]

    const totalAmount = cartItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0,
    )
    const totalTax = cartItems.reduce(
      (total, item) =>
        total + (item.price * item.quantity * item.tax_rate) / 100,
      0,
    )

    const items = cartItems.map((item) => ({
      product_id: item.id,
      quantity: item.quantity,
      unit_price: item.price,
      tax_amount: (item.price * item.quantity * item.tax_rate) / 100,
    }))

    const saleData = {
      sale_date: saleDate,
      total_amount: totalAmount,
      total_tax: totalTax,
      items: items,
    }

    try {
      await api.post('/api/sale/store', saleData)
      await decreaseStock(saleData.items)
      await fetchProducts()
      setCartItems([])
      toast.success('Venda salva com sucesso!')
    } catch (error) {
      toast.error('Erro ao salvar venda')
    }
  }

  const decreaseStock = async (items) => {
    try {
      for (const item of items) {
        await api.put(
          `/api/product/${item.product_id}/decrease-stock/${item.quantity}`,
        )
      }
    } catch (error) {
      console.error('Failed to decrease stock:', error)
    }
  }

  const fetchProducts = async () => {
    setIsLoading(true)
    try {
      const response = await api.get('/api/product')
      setProducts(response.data)
    } catch (error) {
      toast.error('Erro ao buscar dados.')
      console.error('Error fetching data:', error)
    } finally {
      setIsLoading(false)
    }
  }

  useEffect(() => {
    fetchProducts()
  }, [])

  return (
    <>
      <Header cartItems={cartItems} onSubmit={submitSale} />
      <ProductSearch
        products={products}
        cartItems={cartItems}
        onAddToCart={handleAddToCart}
        onRemoveToCart={handleRemoveFromCart}
      />
    </>
  )
}

export default SalesPage
