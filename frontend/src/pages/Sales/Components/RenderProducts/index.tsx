import { useEffect, useState } from 'react'
import { Box, TableCell, TableRow, TextField } from '@mui/material'
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline'
import RemoveCircleOutlineIcon from '@mui/icons-material/RemoveCircleOutline'

const RenderProducts = ({
  filteredProducts,
  product,
  cartItems,
  onAddToCart,
  onRemoveToCart,
}) => {
  const [quantity, setQuantity] = useState('')

  const handleQuantityChange = (e) => {
    const newQuantity = e.target.value

    if (
      /^\d*$/.test(newQuantity) &&
      newQuantity <= product?.quantity_in_stock
    ) {
      setQuantity(newQuantity)
    }
  }

  const handleAddClick = () => {
    onAddToCart(product?.id, quantity)
  }

  const handleRemoveClick = () => {
    onRemoveToCart(product?.id)

    setQuantity('')
  }

  useEffect(() => {
    if (!cartItems.length) {
      setQuantity('')
    }
  }, [cartItems])

  useEffect(() => {
    setQuantity(() => {
      const itemInCart = cartItems.find((item) => item.id === product.id)

      return itemInCart ? itemInCart.quantity.toString() : ''
    })
  }, [filteredProducts])

  return (
    <TableRow key={product?.id}>
      <TableCell>{product?.name}</TableCell>
      <TableCell>R$ {product?.price}</TableCell>
      <TableCell>
        {product?.quantity_in_stock && quantity
          ? product?.quantity_in_stock - parseInt(quantity)
          : product?.quantity_in_stock}
      </TableCell>
      <TableCell sx={{ display: 'flex', width: '100%', alignItems: 'center' }}>
        <TextField
          sx={{ width: 100, marginRight: 1 }}
          type="text"
          value={quantity}
          onChange={handleQuantityChange}
          variant="outlined"
          size="small"
          disabled={cartItems.find((item) => item.id === product.id)}
        />
        <Box width={40}>
          {quantity &&
            (!cartItems.find((item) => item.id === product.id) ? (
              <AddCircleOutlineIcon
                color="success"
                sx={{ fontSize: 32, cursor: 'pointer' }}
                onClick={handleAddClick}
              />
            ) : (
              <RemoveCircleOutlineIcon
                color="error"
                sx={{ fontSize: 32, cursor: 'pointer' }}
                onClick={handleRemoveClick}
              />
            ))}
        </Box>
      </TableCell>
    </TableRow>
  )
}

export default RenderProducts
