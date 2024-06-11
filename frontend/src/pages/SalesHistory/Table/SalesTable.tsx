import React from 'react'
import Table from '@mui/material/Table'
import TableBody from '@mui/material/TableBody'
import TableCell from '@mui/material/TableCell'
import TableContainer from '@mui/material/TableContainer'
import TableHead from '@mui/material/TableHead'
import TableRow from '@mui/material/TableRow'
import Typography from '@mui/material/Typography'
import PriceCheckIcon from '@mui/icons-material/PriceCheck'

import { Box, Card, CardContent, Divider, Paper } from '@mui/material'

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}

const SalesTable = ({ sales }) => {
  return (
    <Box sx={{ padding: 2 }}>
      {sales.map((sale) => (
        <Card sx={{ marginBottom: 2 }}>
          <CardContent>
            <Typography
              variant="h5"
              component="div"
              gutterBottom
              sx={{ display: 'flex', alignItems: 'center' }}
            >
              <PriceCheckIcon sx={{ fontSize: '32px', marginRight: '8px' }} />
              Venda #{sale.id} - {formatDate(sale?.sale_date)}
            </Typography>
            <Typography variant="body1">
              Total: R$ {parseFloat(sale.total_amount).toFixed(2)}
            </Typography>
            <Typography variant="body1">
              Impostos: R$ {parseFloat(sale.total_tax).toFixed(2)}
            </Typography>
            <Typography variant="body1">
              Quantidade total de itens:{' '}
              {sale.items.reduce((sum, item) => sum + item.quantity, 0)}
            </Typography>
            <Divider sx={{ margin: '16px 0' }} />

            {/* Detalhes dos itens */}
            <Box sx={{ width: '100%' }}>
              <TableContainer component={Paper}>
                <Table aria-label="sales items table">
                  <TableHead>
                    <TableRow>
                      <TableCell>Produto</TableCell>
                      <TableCell>Tipo</TableCell>
                      <TableCell align="right">Quantidade</TableCell>
                      <TableCell align="right">Preço Unitário</TableCell>
                      <TableCell align="right">Preço Total</TableCell>
                      <TableCell align="right">Impostos</TableCell>
                    </TableRow>
                  </TableHead>
                  <TableBody>
                    {sale.items.map((item) => (
                      <TableRow key={item.product_id}>
                        <TableCell>{item.product_name}</TableCell>
                        <TableCell>{item.product_type}</TableCell>
                        <TableCell align="right">{item.quantity}</TableCell>
                        <TableCell align="right">
                          R$ {parseFloat(item.unit_price).toFixed(2)}
                        </TableCell>
                        <TableCell align="right">
                          R$ {parseFloat(item.item_total_price).toFixed(2)}
                        </TableCell>
                        <TableCell align="right">
                          R$ {parseFloat(item.item_tax_amount).toFixed(2)}
                        </TableCell>
                      </TableRow>
                    ))}
                  </TableBody>
                </Table>
              </TableContainer>
            </Box>
          </CardContent>
        </Card>
      ))}
    </Box>
  )
}

export default SalesTable
