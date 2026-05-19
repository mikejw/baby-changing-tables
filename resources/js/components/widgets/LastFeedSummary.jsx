import { motion } from 'framer-motion'

function formatFeedingType(breastFed, formulaOunces) {
  const parts = []
  if (breastFed) {
    parts.push('Breast fed')
  }
  if (formulaOunces) {
    parts.push(`${formulaOunces} oz`)
  }
  return parts.length > 0 ? parts.join(' · ') : '—'
}

export default function LastFeedSummary({ loggedAt, cryLevel, breastFed, formulaOunces }) {
  if (!loggedAt) {
    return (
      <motion.div className="rounded-lg border border-dashed border-[#19140035] dark:border-[#3E3E3A] p-6 text-sm text-[#706f6c] dark:text-[#A1A09A]">
        No feeding logged yet.
      </motion.div>
    )
  }

  return (
    <motion.div className="rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-6 shadow-sm">
      <h2 className="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Latest feeding</h2>
      <p className="mt-2 text-lg font-semibold">{loggedAt}</p>
      <dl className="mt-4 grid grid-cols-2 gap-3 text-sm">
        <motion.div>
          <dt className="text-[#706f6c] dark:text-[#A1A09A]">Cry</dt>
          <dd>{cryLevel} / 10</dd>
        </motion.div>
        <motion.div>
          <dt className="text-[#706f6c] dark:text-[#A1A09A]">Feeding</dt>
          <dd>{formatFeedingType(breastFed, formulaOunces)}</dd>
        </motion.div>
      </dl>
    </motion.div>
  )
}
