import Modal from '@mui/material/Modal'
import Box from '@mui/material/Box'
import Typography from '@mui/material/Typography'
import Button from '@mui/material/Button'
import IconButton from '@mui/material/IconButton'
import CloseIcon from '@mui/icons-material/Close'
import { HighlightOff } from '@mui/icons-material'

const DeleteModal = ({ open, onClose, onDelete }) => {
  return (
    <Modal
      open={open}
      onClose={onClose}
      aria-labelledby="delete-modal-title"
      aria-describedby="delete-modal-description"
    >
      <Box
        sx={{
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'space-between',
          position: 'absolute',
          top: '30%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: 400,
          height: 250,
          bgcolor: 'background.paper',
          boxShadow: 24,
          p: 4,
        }}
      >
        <HighlightOff
          color="error"
          sx={{ fontSize: '50px', alignSelf: 'center' }}
        />
        <Typography
          id="delete-modal-title"
          variant="h6"
          component="h2"
          sx={{ textAlign: 'center' }}
        >
          Tem certeza que deseja excluir?
          <IconButton
            aria-label="close"
            onClick={onClose}
            sx={{
              position: 'absolute',
              top: 5,
              right: 5,
            }}
          >
            <CloseIcon />
          </IconButton>
        </Typography>
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <Button
            onClick={onClose}
            fullWidth
            variant="outlined"
            color="inherit"
            sx={{ width: 100, alignSelf: 'end' }}
          >
            Cancelar
          </Button>
          <Button
            onClick={onDelete}
            fullWidth
            variant="contained"
            color="error"
            sx={{ width: 80, alignSelf: 'end' }}
          >
            Excluir
          </Button>
        </div>
      </Box>
    </Modal>
  )
}

export default DeleteModal
