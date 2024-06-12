import React, { useEffect, useState } from 'react'
import {
  Typography,
  Grid,
  Paper,
  Box,
  List,
  ListItem,
  ListItemText,
  Button,
} from '@mui/material'
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart'
import MonetizationOnIcon from '@mui/icons-material/MonetizationOn'

const Header = ({ cartItems, onSubmit }) => {
  const [totalQuantity, setTotalQuantity] = useState(0)
  const [totalTaxes, setTotalTaxes] = useState(0)
  const [totalPurchaseValue, setTotalPurchaseValue] = useState(0)
  const [totalPurchase, setTotalPurchase] = useState(0)
  const [itemDetails, setItemDetails] = useState([])

  useEffect(() => {
    if (cartItems) {
      const calculatedDetails = cartItems.map((item) => {
        const itemTotalValue = item.price * item.quantity
        const itemTax = (itemTotalValue * item.tax_rate) / 100

        return {
          ...item,
          itemTotalValue,
          itemTax,
        }
      })

      const sumQuantities = calculatedDetails.reduce(
        (total, item) => total + item.quantity,
        0,
      )
      const sumTotalPurchaseValue = calculatedDetails.reduce(
        (total, item) => total + item.itemTotalValue,
        0,
      )
      const sumTotalTaxes = calculatedDetails.reduce(
        (total, item) => total + item.itemTax,
        0,
      )

      setItemDetails(calculatedDetails)
      setTotalQuantity(sumQuantities)
      setTotalPurchaseValue(sumTotalPurchaseValue)
      setTotalTaxes(sumTotalTaxes)
      setTotalPurchase(sumTotalPurchaseValue + sumTotalTaxes)
    }
  }, [cartItems])

  return (
    <Paper
      elevation={3}
      sx={{ padding: 2, marginBottom: 2, backgroundColor: '#f0f0f0' }}
    >
      <Grid
        container
        spacing={3}
        justifyContent="space-between"
        alignItems="center"
      >
        <Grid item xs={12} md={6}>
          <Box display="flex" alignItems="center">
            <ShoppingCartIcon
              sx={{ fontSize: 40, marginRight: 2, color: '#3f51b5' }}
            />
            <div>
              <Typography variant="h5" gutterBottom>
                Resumo da Compra
              </Typography>
              <List>
                {itemDetails.map((item) => (
                  <ListItem key={item.id} disablePadding>
                    <ListItemText
                      primary={item.name}
                      secondary={`Quantidade: ${item.quantity}, Total: R$ ${item.itemTotalValue.toFixed(2)}, Imposto: R$ ${item.itemTax.toFixed(2)}`}
                    />
                  </ListItem>
                ))}
              </List>
              <Typography variant="body1">
                Total dos Produtos: R$ {totalPurchaseValue.toFixed(2)}
              </Typography>
              <Typography variant="body1">
                Total de Impostos: R$ {totalTaxes.toFixed(2)}
              </Typography>
              <Typography variant="body1" fontWeight="bold">
                Total da Compra: R$ {totalPurchase.toFixed(2)}
              </Typography>
            </div>
          </Box>
        </Grid>
        <Grid item xs={12} md={4}>
          <Box display="flex" alignItems="center">
            <MonetizationOnIcon
              sx={{ fontSize: 40, marginRight: 2, color: '#009688' }}
            />
            <div>
              <Typography variant="h5" gutterBottom>
                Informações Adicionais
              </Typography>
              <Typography variant="body1">
                Total de Itens: {totalQuantity}
              </Typography>
            </div>
          </Box>
        </Grid>
        <Grid item xs={12} md={2}>
          <Box display="flex" justifyContent="flex-end">
            <Button
              color="success"
              variant="contained"
              onClick={() => onSubmit(cartItems)}
              disabled={!cartItems?.length}
            >
              Salvar
            </Button>
          </Box>
        </Grid>
      </Grid>
    </Paper>
  )
}

export default Header
