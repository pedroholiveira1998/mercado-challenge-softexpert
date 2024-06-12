import React, { useEffect, useState } from 'react'
import Modal from '@mui/material/Modal'
import Box from '@mui/material/Box'
import Typography from '@mui/material/Typography'
import Button from '@mui/material/Button'
import TextField from '@mui/material/TextField'
import IconButton from '@mui/material/IconButton'
import CloseIcon from '@mui/icons-material/Close'

const ProductModal = ({ open, onClose, onSubmit, product = null }) => {
  const [formData, setFormData] = useState({ name: '', tax_rate: '' })

  useEffect(() => {
    if (product) {
      setFormData(product)
    } else {
      setFormData({ name: '', tax_rate: '' })
    }
  }, [product])

  const handleChange = (e) => {
    const { name, value } = e.target
    setFormData({ ...formData, [name]: value })
  }

  const handleChangeNumber = (e) => {
    const { name, value } = e.target
    if (value === '' || /^\d+(\.\d*)?$/.test(value)) {
      setFormData({ ...formData, [name]: value })
    }
  }

  const handleSubmit = () => {
    onSubmit(formData)
    setFormData({ name: '', tax_rate: '' })
  }

  const handleClose = () => {
    setFormData({ name: '', tax_rate: '' })
    onClose()
  }

  return (
    <Modal
      open={open}
      onClose={handleClose}
      aria-labelledby="product-modal-title"
      aria-describedby="product-modal-description"
    >
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
          {product ? 'Editar Tipo de Produto' : 'Novo Tipo de Produto'}
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
          margin="normal"
          required
          fullWidth
          label="Nome"
          name="name"
          value={formData.name}
          onChange={handleChange}
        />
        <TextField
          margin="normal"
          required
          fullWidth
          label="Taxa de Imposto"
          name="tax_rate"
          value={formData.tax_rate}
          onChange={handleChangeNumber}
        />
        <Button
          sx={{ mt: 2 }}
          onClick={handleSubmit}
          fullWidth
          variant="contained"
          disabled={!formData?.name || !formData?.tax_rate}
        >
          {product ? 'Salvar Alterações' : 'Criar Tipo de Produto'}
        </Button>
      </Box>
    </Modal>
  )
}

export default ProductModal
