import { motion } from 'framer-motion'
export default function StatCard({ label, value, suffix = '', hint }) {
  const display = value == null ? '—' : `${value}${suffix}`
  return (
    <motion.div
      initial={{ opacity: 0, y: 8 }}
      animate={{ opacity: 1, y: 0 }}
      className="rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-6 shadow-sm"
    >
      <h2 className="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">{label}</h2>
      <p className="mt-2 text-2xl font-semibold tracking-tight">{display}</p>
      {hint ? (
        <p className="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">{hint}</p>
      ) : null}
    </motion.div>
  )
}