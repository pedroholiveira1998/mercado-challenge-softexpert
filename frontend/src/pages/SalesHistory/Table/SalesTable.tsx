import { Paper } from '@mui/material'
import Table from '@mui/material/Table'
import TableBody from '@mui/material/TableBody'
import TableCell from '@mui/material/TableCell'
import TableContainer from '@mui/material/TableContainer'
import TableHead from '@mui/material/TableHead'
import TableRow from '@mui/material/TableRow'

const SalesTable = ({ items }) => {
  return (
    <TableContainer component={Paper}>
      <Table aria-label="sales items table">
        <TableHead>
          <TableRow>
            <TableCell align="left">Produto</TableCell>
            <TableCell align="left">Tipo</TableCell>
            <TableCell align="left">Quantidade</TableCell>
            <TableCell align="left">Preço Unitário</TableCell>
            <TableCell align="left">Preço Total</TableCell>
            <TableCell align="left">Impostos</TableCell>
            <TableCell align="left">Preço Total Sem Impostos</TableCell>
            <TableCell align="left">Preço Final (Com Impostos)</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {items.map((item) => {
            const unitPrice = parseFloat(item.unit_price) || 0
            const quantity = parseFloat(item.quantity) || 0
            const itemTotalPrice = parseFloat(item.item_total_price) || 0
            const itemTaxAmount = parseFloat(item.item_tax_amount) || 0

            const totalWithoutTax = unitPrice * quantity
            const finalPriceWithTax = totalWithoutTax + itemTaxAmount

            return (
              <TableRow key={item.product_id}>
                <TableCell align="left">{item.product_name}</TableCell>
                <TableCell align="left">{item.product_type}</TableCell>
                <TableCell align="left">{quantity}</TableCell>
                <TableCell align="left">R$ {unitPrice.toFixed(2)}</TableCell>
                <TableCell align="left">
                  R$ {itemTotalPrice.toFixed(2)}
                </TableCell>
                <TableCell align="left">
                  R$ {itemTaxAmount.toFixed(2)}
                </TableCell>
                <TableCell align="left">
                  R$ {totalWithoutTax.toFixed(2)}
                </TableCell>
                <TableCell align="left">
                  R$ {finalPriceWithTax.toFixed(2)}
                </TableCell>
              </TableRow>
            )
          })}
        </TableBody>
      </Table>
    </TableContainer>
  )
}

export default SalesTable
