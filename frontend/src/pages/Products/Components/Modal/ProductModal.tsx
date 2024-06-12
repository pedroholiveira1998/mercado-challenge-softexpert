import React, { useState, useEffect } from 'react'
import {
  Modal,
  Box,
  TextField,
  Button,
  Typography,
  IconButton,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
} from '@mui/material'
import CloseIcon from '@mui/icons-material/Close'
import api from '@lib/api'

const ProductModal = ({ open, onClose, onSubmit, product = null }) => {
  const [formData, setFormData] = useState({
    name: '',
    price: '',
    quantity_in_stock: '',
    type_id: '',
  })
  const [productTypes, setProductTypes] = useState([])
  const [selectedTypeId, setSelectedTypeId] = useState('')

  useEffect(() => {
    fetchProductTypes()
  }, [])

  const fetchProductTypes = async () => {
    try {
      const response = await api.get('/api/productType')
      setProductTypes(response.data)
    } catch (error) {
      console.error('Error fetching product types:', error)
    }
  }

  useEffect(() => {
    setFormData(
      product || {
        name: '',
        price: '',
        quantity_in_stock: '',
        type_id: '',
      },
    )
    setSelectedTypeId(product ? product.type_id : '')
  }, [product])

  const handleChange = (e) => {
    const { name, value } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }))
  }

  const handleTypeChange = (e) => {
    setSelectedTypeId(e.target.value)
    handleChange(e)
  }

  const handleSubmit = () => {
    onSubmit(formData)
    setFormData({
      name: '',
      price: '',
      quantity_in_stock: '',
      type_id: '',
    })
    setSelectedTypeId('')
  }

  const handleClose = () => {
    console.log(formData)
    setFormData({
      name: '',
      price: '',
      quantity_in_stock: '',
      type_id: '',
    })
    setSelectedTypeId('')
    onClose()
  }

  return (
    <Modal open={open} onClose={handleClose}>
      <Box
        sx={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: 400,
          bgcolor: 'background.paper',
          boxShadow: 24,
          p: 4,
        }}
      >
        <Typography
          id="product-modal-title"
          variant="h6"
          component="h2"
          sx={{ textAlign: 'center' }}
        >
          {product ? 'Editar Produto' : 'Novo Produto'}
          <IconButton
            aria-label="close"
            onClick={handleClose}
            sx={{
              position: 'absolute',
              top: 5,
              right: 5,
            }}
          >
            <CloseIcon />
          </IconButton>
        </Typography>
        <TextField
          fullWidth
          margin="normal"
          name="name"
          label="Nome"
          value={formData.name}
          onChange={handleChange}
        />
        <TextField
          fullWidth
          margin="normal"
          name="price"
          label="Preço"
          type="number"
          value={formData.price}
          onChange={handleChange}
        />
        <TextField
          fullWidth
          margin="normal"
          name="quantity_in_stock"
          label="Quantidade em Estoque"
          type="number"
          value={formData.quantity_in_stock}
          onChange={handleChange}
        />
        <FormControl fullWidth margin="normal">
          <InputLabel>Tipo de Produto</InputLabel>
          <Select
            name="type_id"
            value={selectedTypeId}
            onChange={handleTypeChange}
            label="Tipo de Produto"
          >
            {productTypes.map((productType) => (
              <MenuItem key={productType.id} value={productType.id}>
                {productType.name}
              </MenuItem>
            ))}
          </Select>
        </FormControl>
        <Button
          sx={{ mt: 2 }}
          onClick={handleSubmit}
          fullWidth
          variant="contained"
          disabled={
            !formData?.name ||
            !formData?.price ||
            !formData?.quantity_in_stock ||
            !selectedTypeId
          }
        >
          {product ? 'Salvar Alterações' : 'Criar Produto'}
        </Button>
      </Box>
    </Modal>
  )
}

export default ProductModal
