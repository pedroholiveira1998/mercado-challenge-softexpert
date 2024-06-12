import React from 'react'
import Drawer from '@mui/material/Drawer'
import List from '@mui/material/List'
import ListItem from '@mui/material/ListItem'
import ListItemIcon from '@mui/material/ListItemIcon'
import ListItemText from '@mui/material/ListItemText'
import { Link } from 'react-router-dom'
import DashboardIcon from '@mui/icons-material/Dashboard'
import StorefrontIcon from '@mui/icons-material/Storefront'
import CategoryIcon from '@mui/icons-material/Category'
import Typography from '@mui/material/Typography'
import HistoryIcon from '@mui/icons-material/History'

const Sidebar = () => {
  return (
    <Drawer
      variant="permanent"
      sx={{
        width: 240,
        flexShrink: 0,
        '& .MuiDrawer-paper': {
          width: 240,
          backgroundColor: '#303030',
          color: '#fff',
        },
      }}
    >
      <div style={{ marginTop: '24px', marginBottom: '16px' }}>
        <Typography variant="h5" textAlign="center">
          Dashboard
        </Typography>
      </div>
      <List>
        <ListItem button component={Link} to="/produtos">
          <ListItemIcon>
            <DashboardIcon sx={{ color: '#fff' }} />
          </ListItemIcon>
          <ListItemText primary="Produtos" />
        </ListItem>
        <ListItem button component={Link} to="/tipo-produtos">
          <ListItemIcon>
            <CategoryIcon sx={{ color: '#fff' }} />
          </ListItemIcon>
          <ListItemText primary="Tipo de Produto" />
        </ListItem>
        <ListItem button component={Link} to="/vendas">
          <ListItemIcon>
            <StorefrontIcon sx={{ color: '#fff' }} />
          </ListItemIcon>
          <ListItemText primary="Vendas" />
        </ListItem>
        <ListItem button component={Link} to="/historico-vendas">
          <ListItemIcon>
            <HistoryIcon sx={{ color: '#fff' }} />
          </ListItemIcon>
          <ListItemText primary="Histórico Vendas" />
        </ListItem>
      </List>
    </Drawer>
  )
}

export default Sidebar
