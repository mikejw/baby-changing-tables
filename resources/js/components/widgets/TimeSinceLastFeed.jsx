import { useEffect, useState } from 'react'
import { motion } from 'framer-motion'
function formatTimeSince(isoString) {
  const then = new Date(isoString).getTime()
  if (Number.isNaN(then)) return 'Unknown'
  const seconds = Math.floor((Date.now() - then) / 1000)
  if (seconds < 0) return 'In the future'
  if (seconds < 60) return 'Just now'
  const minutes = Math.floor(seconds / 60)
  if (minutes < 60) {
    return `${minutes} minute${minutes === 1 ? '' : 's'} ago`
  }
  const hours = Math.floor(minutes / 60)
  if (hours < 24) {
    return `${hours} hour${hours === 1 ? '' : 's'} ago`
  }
  const days = Math.floor(hours / 24)
  if (days < 7) {
    return `${days} day${days === 1 ? '' : 's'} ago`
  }
  return new Date(isoString).toLocaleString(undefined, {
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
function formatExactTime(isoString) {
  return new Date(isoString).toLocaleString(undefined, {
    weekday: 'short',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
export default function TimeSinceLastFeed({ loggedAtIso }) {
  const [label, setLabel] = useState(() =>
    loggedAtIso ? formatTimeSince(loggedAtIso) : null,
  )
  useEffect(() => {
    if (!loggedAtIso) return
    const tick = () => setLabel(formatTimeSince(loggedAtIso))
    tick()
    const id = window.setInterval(tick, 60_000)
    return () => window.clearInterval(id)
  }, [loggedAtIso])
  if (!loggedAtIso) {
    return (
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        className="rounded-lg border border-dashed border-[#19140035] dark:border-[#3E3E3A] p-6 text-sm text-[#706f6c] dark:text-[#A1A09A]"
      >
        No feeds recorded yet.
      </motion.div>
    )
  }
  return (
    <motion.div
      initial={{ opacity: 0, y: 8 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.25 }}
      className="rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-6 shadow-sm"
    >
      <h2 className="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
        Time since last feed
      </h2>
      <p className="mt-2 text-2xl font-semibold tracking-tight">{label}</p>
      <p className="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
        Last logged {formatExactTime(loggedAtIso)}
      </p>
    </motion.div>
  )
}