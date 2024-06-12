import Typography from '@mui/material/Typography'
import PriceCheckIcon from '@mui/icons-material/PriceCheck'
import { Box, Card, CardContent, Divider } from '@mui/material'
import SalesTable from '../Table/SalesTable'

const SalesCard = ({ sales }) => {
  const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('pt-BR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    })
  }

  return (
    <Box sx={{ padding: 2 }}>
      {sales.map((sale) => {
        const totalPurchase =
          parseFloat(sale.total_amount) + parseFloat(sale.total_tax)

        return (
          <Card sx={{ marginBottom: 2 }} key={sale.id}>
            <CardContent>
              <Typography
                variant="h5"
                component="div"
                gutterBottom
                sx={{ display: 'flex', alignItems: 'center' }}
              >
                <PriceCheckIcon sx={{ fontSize: '32px', marginRight: '8px' }} />
                Venda #{sale.id} - {formatDate(sale.sale_date)}
              </Typography>
              <Typography variant="body1">
                Total dos Produtos: R$ {parseFloat(sale.total_amount).toFixed(2)}
              </Typography>
              <Typography variant="body1">
                Impostos: R$ {parseFloat(sale.total_tax).toFixed(2)}
              </Typography>
              <Typography variant="body1">
                Quantidade total de itens:{' '}
                {sale.items.reduce((sum, item) => sum + item.quantity, 0)}
              </Typography>
              <Typography
                variant="body1"
                fontWeight="bold"
                sx={{ marginTop: 1 }}
              >
                Total da Compra: R$ {totalPurchase.toFixed(2)}
              </Typography>
              <Divider sx={{ margin: '16px 0' }} />
              <SalesTable items={sale.items} />
            </CardContent>
          </Card>
        )
      })}
    </Box>
  )
}

export default SalesCard
